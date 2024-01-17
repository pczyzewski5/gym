<?php

declare(strict_types=1);

namespace gym;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240117133627 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'creates table tags';
    }

    public function up(Schema $schema): void
    {
        $sql = <<<SQL
CREATE TABLE tags
(
    id       VARCHAR(36) NOT NULL,
    owner_id VARCHAR(36) NOT NULL,
    owner    VARCHAR(36) NOT NULL,
    tag      VARCHAR(36) NOT NULL,
    UNIQUE (id)
) DEFAULT CHARACTER SET UTF8
  COLLATE 'UTF8_unicode_ci';
SQL;
        $this->addSql($sql);
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE tags');;
    }
}
