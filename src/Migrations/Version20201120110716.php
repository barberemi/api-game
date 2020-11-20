<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201120110716 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE bind_characteristic CHANGE user_id user_id INT DEFAULT NULL, CHANGE monster_id monster_id INT DEFAULT NULL, CHANGE characteristic_id characteristic_id INT DEFAULT NULL, CHANGE skill_id skill_id INT DEFAULT NULL, CHANGE base_academy_id base_academy_id INT DEFAULT NULL, CHANGE item_id item_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE message CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE monster ADD level_tower INT NOT NULL, CHANGE academy_id academy_id INT DEFAULT NULL, CHANGE map_id map_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE skill CHANGE parent_id parent_id INT DEFAULT NULL, CHANGE academy_id academy_id INT DEFAULT NULL, CHANGE type type VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE academy_id academy_id INT DEFAULT NULL, CHANGE guild_id guild_id INT DEFAULT NULL, CHANGE salt salt VARCHAR(64) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE bind_characteristic CHANGE user_id user_id INT DEFAULT NULL, CHANGE monster_id monster_id INT DEFAULT NULL, CHANGE skill_id skill_id INT DEFAULT NULL, CHANGE base_academy_id base_academy_id INT DEFAULT NULL, CHANGE item_id item_id INT DEFAULT NULL, CHANGE characteristic_id characteristic_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE message CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE monster DROP level_tower, CHANGE academy_id academy_id INT DEFAULT NULL, CHANGE map_id map_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE skill CHANGE parent_id parent_id INT DEFAULT NULL, CHANGE academy_id academy_id INT DEFAULT NULL, CHANGE type type VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE user CHANGE academy_id academy_id INT DEFAULT NULL, CHANGE guild_id guild_id INT DEFAULT NULL, CHANGE salt salt VARCHAR(64) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
    }
}
