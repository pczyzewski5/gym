<?php

declare(strict_types=1);

namespace gym;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240117133538 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'creates table users';
    }

    public function up(Schema $schema): void
    {
        $sql = <<<SQL
CREATE TABLE users
(
    id             VARCHAR(36) NOT NULL,
    email          VARCHAR(36) NOT NULL,
    username       VARCHAR(36) NOT NULL,
    roles          JSON NOT NULL,
    password       VARCHAR(255) NOT NULL,
    is_active      BOOLEAN NOT NULL,
    created_at     DATETIME NOT NULL,
    UNIQUE (email)
) DEFAULT CHARACTER SET UTF8
  COLLATE 'UTF8_unicode_ci';
SQL;
        $this->addSql($sql);
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE users');
    }
}
