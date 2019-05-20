<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190520000000 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $sql = file_get_contents($this->sqlFilePath());

        $this->addSql($sql);
    }

    public function down(Schema $schema) : void
    {

    }

    private function sqlFilePath(): string
    {
        return __DIR__.'/../bootstrap/structure.sql';
    }
}
