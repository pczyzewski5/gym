<?php

declare(strict_types=1);

namespace gym;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240122184950 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'creates rests table';
    }

    public function up(Schema $schema): void
    {
        $sql = <<<SQL
CREATE TABLE rests
(
    station_id      VARCHAR(36) NOT NULL,
    exercise_id     VARCHAR(36) NOT NULL,
    rest           TINYINT(3) NOT NULL,
    UNIQUE (station_id, exercise_id)
) DEFAULT CHARACTER SET UTF8
  COLLATE 'UTF8_unicode_ci';
SQL;
        $this->addSql($sql);
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE rests');
    }
}
