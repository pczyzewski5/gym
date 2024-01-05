<?php

declare(strict_types=1);

namespace migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231202201111 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'create exercises table';
    }

    public function up(Schema $schema): void
    {
        $sql = <<<SQL
CREATE TABLE exercises
(
    id            VARCHAR(36) NOT NULL,
    name          VARCHAR(72) NOT NULL,
    separate_load BOOLEAN NOT NULL,
    description   TEXT,
    image         VARCHAR(72),
    UNIQUE (id)
) DEFAULT CHARACTER SET UTF8
  COLLATE 'UTF8_unicode_ci';
SQL;
        $this->addSql($sql);
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE exercises;');
    }
}
