<?php

declare(strict_types=1);

namespace gym;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240117133635 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'creates table exercises_to_stations';
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
        $this->addSql('DROP TABLE exercises_to_stations');
    }
}
