<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220922135049 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
    $this->addSql('INSERT IGNORE INTO monster (id, academy_id, name, created_at, updated_at, given_xp, level, map_id, image, given_money, is_boss, is_guild_boss) VALUES (3, 10, "Roi sorcier squelette", "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'", 761, 4, 3, "Fallen_Angels_2/Fallen_Angels_2.png", 1050, 1, 0)');
    $this->addSql('INSERT IGNORE INTO monster (id, academy_id, name, created_at, updated_at, given_xp, level, map_id, image, given_money, is_boss, is_guild_boss) VALUES (4, 7, "Berseker", "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'", 167, 1, 3, "Goblin/Goblin.png", 200, 0, 0)');
    $this->addSql('INSERT IGNORE INTO monster (id, academy_id, name, created_at, updated_at, given_xp, level, map_id, image, given_money, is_boss, is_guild_boss) VALUES (5, 7, "Golgo", "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'", 300, 8, NULL, "Golem_1/Golem_1.png", 200, 0, 1)');
    $this->addSql('INSERT IGNORE INTO monster (id, academy_id, name, created_at, updated_at, given_xp, level, map_id, image, given_money, is_boss, is_guild_boss) VALUES (7, 7, "Golmou", "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'", 300, 12, NULL, "Golem_3/Golem_3.png", 200, 0, 1)');
    $this->addSql('INSERT IGNORE INTO monster (id, academy_id, name, created_at, updated_at, given_xp, level, map_id, image, given_money, is_boss, is_guild_boss) VALUES (9, 7, "Mito", "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'", 300, 15, NULL, "Minotaur_3/Minotaur_3.png", 200, 0, 1)');
    $this->addSql('INSERT IGNORE INTO monster (id, academy_id, name, created_at, updated_at, given_xp, level, map_id, image, given_money, is_boss, is_guild_boss) VALUES (10, 7, "Salto", "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'", 300, 20, NULL, "Satyr_3/Satyr_3.png", 200, 0, 1)');
    $this->addSql('INSERT IGNORE INTO monster (id, academy_id, name, created_at, updated_at, given_xp, level, map_id, image, given_money, is_boss, is_guild_boss) VALUES (12, 8, "Ange déchu", "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'", 191, 2, 3, "Fallen_Angels_3/Fallen_Angels_3.png", 100, 0, 0)');
    $this->addSql('INSERT IGNORE INTO monster (id, academy_id, name, created_at, updated_at, given_xp, level, map_id, image, given_money, is_boss, is_guild_boss) VALUES (13, 10, "Sorcier squelette", "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'", 221, 3, 3, "Wraith_1/Wraith_1.png", 100, 0, 0)');
    $this->addSql('INSERT IGNORE INTO monster (id, academy_id, name, created_at, updated_at, given_xp, level, map_id, image, given_money, is_boss, is_guild_boss) VALUES (14, 7, "Brute", "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'", 444, 8, 4, "Orc/Orc.png", 100, 0, 0)');
    $this->addSql('INSERT IGNORE INTO monster (id, academy_id, name, created_at, updated_at, given_xp, level, map_id, image, given_money, is_boss, is_guild_boss) VALUES (15, 7, "Brutus", "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'", 1530, 9, 4, "Ogre/Ogre.png", 100, 1, 0)');
    $this->addSql('INSERT IGNORE INTO monster (id, academy_id, name, created_at, updated_at, given_xp, level, map_id, image, given_money, is_boss, is_guild_boss) VALUES (16, 8, "Crapaud cracheur", "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'", 385, 7, 4, "Satyr_1/Satyr_1.png", 100, 0, 0)');
    $this->addSql('INSERT IGNORE INTO monster (id, academy_id, name, created_at, updated_at, given_xp, level, map_id, image, given_money, is_boss, is_guild_boss) VALUES (17, 10, "Jafar", "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'", 510, 9, 4, "Reaper_Man_1/Reaper_Man_1.png", 100, 0, 0)');


    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
