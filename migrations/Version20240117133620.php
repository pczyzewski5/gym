<?php

declare(strict_types=1);

namespace gym;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240117133620 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'creates table trainings';
    }

    public function up(Schema $schema): void
    {
        $sql = <<<SQL
CREATE TABLE trainings
(
    id                VARCHAR(36) NOT NULL,
    status            VARCHAR(36) NOT NULL,
    training_date     DATETIME NOT NULL,
    training_started  DATETIME,
    training_finished DATETIME,
    repeated          BOOLEAN NOT NULL,
    created_at        DATETIME NOT NULL,
    UNIQUE (id)
) DEFAULT CHARACTER SET UTF8
  COLLATE 'UTF8_unicode_ci';
SQL;
        $this->addSql($sql);
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE trainings');
    }
}
