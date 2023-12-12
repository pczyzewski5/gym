<?php

declare(strict_types=1);

namespace migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231202301111 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'create trainings table';
    }

    public function up(Schema $schema): void
    {
        $sql = <<<SQL
CREATE TABLE trainings
(
    id         VARCHAR(36) NOT NULL,
    status     VARCHAR(36) NOT NULL,
    date       DATETIME NOT NULL,
    created_at DATETIME NOT NULL,
    UNIQUE (id)
) DEFAULT CHARACTER SET UTF8
  COLLATE 'UTF8_unicode_ci';
SQL;
        $this->addSql($sql);
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE trainings;');
    }
}
