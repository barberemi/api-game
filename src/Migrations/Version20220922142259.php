<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220922142259 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('INSERT IGNORE INTO monster_skill (monster_id, skill_id) VALUES (3, 28)');
        $this->addSql('INSERT IGNORE INTO monster_skill (monster_id, skill_id) VALUES (3, 29)');
        $this->addSql('INSERT IGNORE INTO monster_skill (monster_id, skill_id) VALUES (3, 30)');
        $this->addSql('INSERT IGNORE INTO monster_skill (monster_id, skill_id) VALUES (4, 10)');
        $this->addSql('INSERT IGNORE INTO monster_skill (monster_id, skill_id) VALUES (5, 10)');
        $this->addSql('INSERT IGNORE INTO monster_skill (monster_id, skill_id) VALUES (7, 10)');
        $this->addSql('INSERT IGNORE INTO monster_skill (monster_id, skill_id) VALUES (9, 10)');
        $this->addSql('INSERT IGNORE INTO monster_skill (monster_id, skill_id) VALUES (10, 10)');
        $this->addSql('INSERT IGNORE INTO monster_skill (monster_id, skill_id) VALUES (12, 20)');
        $this->addSql('INSERT IGNORE INTO monster_skill (monster_id, skill_id) VALUES (12, 21)');
        $this->addSql('INSERT IGNORE INTO monster_skill (monster_id, skill_id) VALUES (13, 28)');
        $this->addSql('INSERT IGNORE INTO monster_skill (monster_id, skill_id) VALUES (13, 29)');
        $this->addSql('INSERT IGNORE INTO monster_skill (monster_id, skill_id) VALUES (13, 30)');
        $this->addSql('INSERT IGNORE INTO monster_skill (monster_id, skill_id) VALUES (14, 8)');
        $this->addSql('INSERT IGNORE INTO monster_skill (monster_id, skill_id) VALUES (14, 10)');
        $this->addSql('INSERT IGNORE INTO monster_skill (monster_id, skill_id) VALUES (14, 15)');
        $this->addSql('INSERT IGNORE INTO monster_skill (monster_id, skill_id) VALUES (14, 19)');
        $this->addSql('INSERT IGNORE INTO monster_skill (monster_id, skill_id) VALUES (15, 8)');
        $this->addSql('INSERT IGNORE INTO monster_skill (monster_id, skill_id) VALUES (15, 9)');
        $this->addSql('INSERT IGNORE INTO monster_skill (monster_id, skill_id) VALUES (15, 10)');
        $this->addSql('INSERT IGNORE INTO monster_skill (monster_id, skill_id) VALUES (15, 15)');
        $this->addSql('INSERT IGNORE INTO monster_skill (monster_id, skill_id) VALUES (15, 18)');
        $this->addSql('INSERT IGNORE INTO monster_skill (monster_id, skill_id) VALUES (15, 19)');
        $this->addSql('INSERT IGNORE INTO monster_skill (monster_id, skill_id) VALUES (16, 20)');
        $this->addSql('INSERT IGNORE INTO monster_skill (monster_id, skill_id) VALUES (16, 21)');
        $this->addSql('INSERT IGNORE INTO monster_skill (monster_id, skill_id) VALUES (16, 22)');
        $this->addSql('INSERT IGNORE INTO monster_skill (monster_id, skill_id) VALUES (16, 23)');
        $this->addSql('INSERT IGNORE INTO monster_skill (monster_id, skill_id) VALUES (16, 24)');
        $this->addSql('INSERT IGNORE INTO monster_skill (monster_id, skill_id) VALUES (17, 28)');
        $this->addSql('INSERT IGNORE INTO monster_skill (monster_id, skill_id) VALUES (17, 30)');
        $this->addSql('INSERT IGNORE INTO monster_skill (monster_id, skill_id) VALUES (17, 31)');
        $this->addSql('INSERT IGNORE INTO monster_skill (monster_id, skill_id) VALUES (17, 32)');
        $this->addSql('INSERT IGNORE INTO monster_skill (monster_id, skill_id) VALUES (17, 33)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
