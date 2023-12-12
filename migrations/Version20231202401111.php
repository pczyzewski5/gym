<?php

declare(strict_types=1);

namespace migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231202401111 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'create tags table';
    }

    public function up(Schema $schema): void
    {
        $sql = <<<SQL
CREATE TABLE tags
(
    owner_id VARCHAR(36) NOT NULL,
    owner    VARCHAR(36) NOT NULL,
    tag      VARCHAR(36) NOT NULL,
    UNIQUE (owner_id, owner, tag)
) DEFAULT CHARACTER SET UTF8
  COLLATE 'UTF8_unicode_ci';
SQL;
        $this->addSql($sql);
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE tags;');
    }
}
