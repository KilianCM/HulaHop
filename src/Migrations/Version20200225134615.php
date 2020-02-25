<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200225134615 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_64C19C1796A8F92');
        $this->addSql('CREATE TEMPORARY TABLE __temp__category AS SELECT id, parent_category_id, name FROM category');
        $this->addSql('DROP TABLE category');
        $this->addSql('CREATE TABLE category (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, parent_category_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL COLLATE BINARY, CONSTRAINT FK_64C19C1796A8F92 FOREIGN KEY (parent_category_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO category (id, parent_category_id, name) SELECT id, parent_category_id, name FROM __temp__category');
        $this->addSql('DROP TABLE __temp__category');
        $this->addSql('CREATE INDEX IDX_64C19C1796A8F92 ON category (parent_category_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__game AS SELECT id, name, description, image_url, recommended_age, party_time FROM game');
        $this->addSql('DROP TABLE game');
        $this->addSql('CREATE TABLE game (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, category_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL COLLATE BINARY, description VARCHAR(400) DEFAULT NULL COLLATE BINARY, image_url VARCHAR(400) DEFAULT NULL COLLATE BINARY, recommended_age INTEGER DEFAULT NULL, party_time INTEGER DEFAULT NULL, CONSTRAINT FK_232B318C12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO game (id, name, description, image_url, recommended_age, party_time) SELECT id, name, description, image_url, recommended_age, party_time FROM __temp__game');
        $this->addSql('DROP TABLE __temp__game');
        $this->addSql('CREATE INDEX IDX_232B318C12469DE2 ON game (category_id)');
        $this->addSql('DROP INDEX IDX_59AA7D45E48FD905');
        $this->addSql('DROP INDEX IDX_59AA7D45A76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user_game AS SELECT user_id, game_id FROM user_game');
        $this->addSql('DROP TABLE user_game');
        $this->addSql('CREATE TABLE user_game (user_id INTEGER NOT NULL, game_id INTEGER NOT NULL, PRIMARY KEY(user_id, game_id), CONSTRAINT FK_59AA7D45A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_59AA7D45E48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO user_game (user_id, game_id) SELECT user_id, game_id FROM __temp__user_game');
        $this->addSql('DROP TABLE __temp__user_game');
        $this->addSql('CREATE INDEX IDX_59AA7D45E48FD905 ON user_game (game_id)');
        $this->addSql('CREATE INDEX IDX_59AA7D45A76ED395 ON user_game (user_id)');
        $this->addSql('DROP INDEX IDX_F7129A80233D34C1');
        $this->addSql('DROP INDEX IDX_F7129A803AD8644E');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user_user AS SELECT user_source, user_target FROM user_user');
        $this->addSql('DROP TABLE user_user');
        $this->addSql('CREATE TABLE user_user (user_source INTEGER NOT NULL, user_target INTEGER NOT NULL, PRIMARY KEY(user_source, user_target), CONSTRAINT FK_F7129A803AD8644E FOREIGN KEY (user_source) REFERENCES user (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_F7129A80233D34C1 FOREIGN KEY (user_target) REFERENCES user (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO user_user (user_source, user_target) SELECT user_source, user_target FROM __temp__user_user');
        $this->addSql('DROP TABLE __temp__user_user');
        $this->addSql('CREATE INDEX IDX_F7129A80233D34C1 ON user_user (user_target)');
        $this->addSql('CREATE INDEX IDX_F7129A803AD8644E ON user_user (user_source)');
        $this->addSql('DROP INDEX IDX_D8892622E48FD905');
        $this->addSql('DROP INDEX IDX_D8892622A76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__rating AS SELECT id, user_id, game_id, comment, note FROM rating');
        $this->addSql('DROP TABLE rating');
        $this->addSql('CREATE TABLE rating (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER DEFAULT NULL, game_id INTEGER DEFAULT NULL, comment VARCHAR(255) DEFAULT NULL COLLATE BINARY, note INTEGER NOT NULL, CONSTRAINT FK_D8892622A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D8892622E48FD905 FOREIGN KEY (game_id) REFERENCES game (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO rating (id, user_id, game_id, comment, note) SELECT id, user_id, game_id, comment, note FROM __temp__rating');
        $this->addSql('DROP TABLE __temp__rating');
        $this->addSql('CREATE INDEX IDX_D8892622E48FD905 ON rating (game_id)');
        $this->addSql('CREATE INDEX IDX_D8892622A76ED395 ON rating (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_64C19C1796A8F92');
        $this->addSql('CREATE TEMPORARY TABLE __temp__category AS SELECT id, parent_category_id, name FROM category');
        $this->addSql('DROP TABLE category');
        $this->addSql('CREATE TABLE category (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, parent_category_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO category (id, parent_category_id, name) SELECT id, parent_category_id, name FROM __temp__category');
        $this->addSql('DROP TABLE __temp__category');
        $this->addSql('CREATE INDEX IDX_64C19C1796A8F92 ON category (parent_category_id)');
        $this->addSql('DROP INDEX IDX_232B318C12469DE2');
        $this->addSql('CREATE TEMPORARY TABLE __temp__game AS SELECT id, name, description, image_url, recommended_age, party_time FROM game');
        $this->addSql('DROP TABLE game');
        $this->addSql('CREATE TABLE game (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(400) DEFAULT NULL, image_url VARCHAR(400) DEFAULT NULL, recommended_age INTEGER DEFAULT NULL, party_time TIME DEFAULT NULL)');
        $this->addSql('INSERT INTO game (id, name, description, image_url, recommended_age, party_time) SELECT id, name, description, image_url, recommended_age, party_time FROM __temp__game');
        $this->addSql('DROP TABLE __temp__game');
        $this->addSql('DROP INDEX IDX_D8892622A76ED395');
        $this->addSql('DROP INDEX IDX_D8892622E48FD905');
        $this->addSql('CREATE TEMPORARY TABLE __temp__rating AS SELECT id, user_id, game_id, comment, note FROM rating');
        $this->addSql('DROP TABLE rating');
        $this->addSql('CREATE TABLE rating (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER DEFAULT NULL, game_id INTEGER DEFAULT NULL, comment VARCHAR(255) DEFAULT NULL, note INTEGER NOT NULL)');
        $this->addSql('INSERT INTO rating (id, user_id, game_id, comment, note) SELECT id, user_id, game_id, comment, note FROM __temp__rating');
        $this->addSql('DROP TABLE __temp__rating');
        $this->addSql('CREATE INDEX IDX_D8892622A76ED395 ON rating (user_id)');
        $this->addSql('CREATE INDEX IDX_D8892622E48FD905 ON rating (game_id)');
        $this->addSql('DROP INDEX IDX_59AA7D45A76ED395');
        $this->addSql('DROP INDEX IDX_59AA7D45E48FD905');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user_game AS SELECT user_id, game_id FROM user_game');
        $this->addSql('DROP TABLE user_game');
        $this->addSql('CREATE TABLE user_game (user_id INTEGER NOT NULL, game_id INTEGER NOT NULL, PRIMARY KEY(user_id, game_id))');
        $this->addSql('INSERT INTO user_game (user_id, game_id) SELECT user_id, game_id FROM __temp__user_game');
        $this->addSql('DROP TABLE __temp__user_game');
        $this->addSql('CREATE INDEX IDX_59AA7D45A76ED395 ON user_game (user_id)');
        $this->addSql('CREATE INDEX IDX_59AA7D45E48FD905 ON user_game (game_id)');
        $this->addSql('DROP INDEX IDX_F7129A803AD8644E');
        $this->addSql('DROP INDEX IDX_F7129A80233D34C1');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user_user AS SELECT user_source, user_target FROM user_user');
        $this->addSql('DROP TABLE user_user');
        $this->addSql('CREATE TABLE user_user (user_source INTEGER NOT NULL, user_target INTEGER NOT NULL, PRIMARY KEY(user_source, user_target))');
        $this->addSql('INSERT INTO user_user (user_source, user_target) SELECT user_source, user_target FROM __temp__user_user');
        $this->addSql('DROP TABLE __temp__user_user');
        $this->addSql('CREATE INDEX IDX_F7129A803AD8644E ON user_user (user_source)');
        $this->addSql('CREATE INDEX IDX_F7129A80233D34C1 ON user_user (user_target)');
    }
}
