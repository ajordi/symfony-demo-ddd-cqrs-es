<?php

namespace App\Shared\Infrastructure\Doctrine;

use Broadway\Domain\AggregateRoot;
use Broadway\EventHandling\EventBus;
use Broadway\EventStore\EventStore;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

abstract class DoctrineRepository
{
    private $entityManager;

    /** @var EventStore */
    private $eventStore;

    /** @var EventBus */
    private $eventBus;

    public function __construct(EntityManager $entityManager, EventStore $eventStore, EventBus $eventBus)
    {
        $this->entityManager = $entityManager;
        $this->eventStore = $eventStore;
        $this->eventBus = $eventBus;
    }

    protected function entityManager(): EntityManager
    {
        return $this->entityManager;
    }

    public function persist(AggregateRoot $root): void
    {
        $this->entityManager()->persist($root);
        $this->entityManager()->flush();
    }

    protected function remove(AggregateRoot $entity): void
    {
        $this->entityManager()->remove($entity);
        $this->entityManager()->flush($entity);
    }

    protected function persister(): callable
    {
        return function (AggregateRoot $entity): void {
            $this->persist($entity);
        };
    }

    protected function remover(): callable
    {
        return function (AggregateRoot $entity): void {
            $this->remove($entity);
        };
    }

    protected function repository($entityClass): EntityRepository
    {
        return $this->entityManager->getRepository($entityClass);
    }

    protected function queryBuilder(): QueryBuilder
    {
        return $this->entityManager->createQueryBuilder();
    }

    public function saveAndEmitEvents(AggregateRoot $entity)
    {
        $this->entityManager()->persist($entity);
        $this->entityManager()->flush();

        $eventStream = $entity->getUncommittedEvents();
        $this->eventStore->append($entity->getAggregateRootId(), $eventStream);

        $this->eventBus->publish($eventStream);
    }
}
