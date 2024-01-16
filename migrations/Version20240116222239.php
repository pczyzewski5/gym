<?php

declare(strict_types=1);

namespace gym;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240116222239 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Creates initial db';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE exercises (id VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, separate_load TINYINT(1) NOT NULL, description VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE exercises_to_stations (exercise_id VARCHAR(255) NOT NULL, station_id VARCHAR(255) NOT NULL, PRIMARY KEY(exercise_id, station_id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE exercises_to_trainings (id VARCHAR(255) NOT NULL, training_id VARCHAR(255) NOT NULL, station_id VARCHAR(255) NOT NULL, exercise_id VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, series_goal INT NOT NULL, repetition_goal INT NOT NULL, kilogram_goal INT NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lifted_weights (id VARCHAR(255) NOT NULL, training_id VARCHAR(255) NOT NULL, station_id VARCHAR(255) NOT NULL, exercise_id VARCHAR(255) NOT NULL, repetition_count INT NOT NULL, kilogram_count INT NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stations (id VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tags (id VARCHAR(255) NOT NULL, owner_id VARCHAR(255) NOT NULL, owner VARCHAR(255) NOT NULL, tag VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trainings (id VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, training_date DATETIME NOT NULL, training_started DATETIME NOT NULL, training_finished DATETIME NOT NULL, repeated TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, roles VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, is_active TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE exercises');
        $this->addSql('DROP TABLE exercises_to_stations');
        $this->addSql('DROP TABLE exercises_to_trainings');
        $this->addSql('DROP TABLE lifted_weights');
        $this->addSql('DROP TABLE stations');
        $this->addSql('DROP TABLE tags');
        $this->addSql('DROP TABLE trainings');
        $this->addSql('DROP TABLE users');
    }
}
