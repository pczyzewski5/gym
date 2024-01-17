<?php

declare(strict_types=1);

namespace gym;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240117133552 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'creates table stations';
    }

    public function up(Schema $schema): void
    {
        $sql = <<<SQL
CREATE TABLE stations
(
    id         VARCHAR(36) NOT NULL,
    name       VARCHAR(36) NOT NULL,
    image      VARCHAR(72) NOT NULL,
    UNIQUE (id)
) DEFAULT CHARACTER SET UTF8
  COLLATE 'UTF8_unicode_ci';
SQL;
        $this->addSql($sql);
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE stations');
    }
}
