<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Type;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190520000001 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $table = $schema->createTable('events');
        $table->addColumn('uuid', Type::STRING, [
            'length' => 36,
            'fixed' => true,
        ]);
        $table->addColumn('playhead', Type::INTEGER, [
            'unsigned' => true,
        ]);
        $table->addColumn('metadata', Type::TEXT);
        $table->addColumn('payload', Type::TEXT);
        $table->addColumn('recorded_on', Type::STRING, [
            'length' => 32,
        ]);
        $table->addColumn('type', Type::TEXT);
        $table->addUniqueIndex(['uuid', 'playhead']);
        $table->setPrimaryKey(['uuid']);
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE events');
    }
}
