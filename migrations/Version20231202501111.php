<?php

declare(strict_types=1);

namespace migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231202501111 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'create exercises_to_stations table';
    }

    public function up(Schema $schema): void
    {
        $sql = <<<SQL
CREATE TABLE exercises_to_stations
(
    exercise_id VARCHAR(36) NOT NULL,
    station_id  VARCHAR(36) NOT NULL,
    UNIQUE (exercise_id, station_id)
) DEFAULT CHARACTER SET UTF8
  COLLATE 'UTF8_unicode_ci';
SQL;
        $this->addSql($sql);
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE exercises_to_stations;');
    }
}
