<?php

declare(strict_types=1);

namespace migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231202701111 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'create lifted_weights table';
    }

    public function up(Schema $schema): void
    {
        $sql = <<<SQL
CREATE TABLE lifted_weights
(
    id              VARCHAR(36) NOT NULL,
    training_id     VARCHAR(36) NOT NULL,
    station_id      VARCHAR(36) NOT NULL,
    exercise_id     VARCHAR(36) NOT NULL,
    repetition_count TINYINT(2) NOT NULL,
    kilogram_count   TINYINT(3) NOT NULL,
    created_at      DATETIME NOT NULL,
    UNIQUE (id)
) DEFAULT CHARACTER SET UTF8
  COLLATE 'UTF8_unicode_ci';
SQL;
        $this->addSql($sql);
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE lifted_weights;');
    }
}
