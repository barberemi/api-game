<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220924205748 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('INSERT IGNORE INTO owm_item (user_id, monster_id, item_id, amount, is_equipped, created_at, updated_at, fight_id, guild_id, map_id) VALUES (NULL, 17, 25, 0, 0, "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'", NULL, NULL, NULL)');
        $this->addSql('INSERT IGNORE INTO owm_item (user_id, monster_id, item_id, amount, is_equipped, created_at, updated_at, fight_id, guild_id, map_id) VALUES (NULL, 17, 24, 0, 0, "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'", NULL, NULL, NULL)');
        $this->addSql('INSERT IGNORE INTO owm_item (user_id, monster_id, item_id, amount, is_equipped, created_at, updated_at, fight_id, guild_id, map_id) VALUES (NULL, 17, 23, 0, 0, "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'", NULL, NULL, NULL)');
        $this->addSql('INSERT IGNORE INTO owm_item (user_id, monster_id, item_id, amount, is_equipped, created_at, updated_at, fight_id, guild_id, map_id) VALUES (NULL, 17, 22, 0, 0, "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'", NULL, NULL, NULL)');
        $this->addSql('INSERT IGNORE INTO owm_item (user_id, monster_id, item_id, amount, is_equipped, created_at, updated_at, fight_id, guild_id, map_id) VALUES (NULL, 17, 10, 0, 0, "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'", NULL, NULL, NULL)');
        $this->addSql('INSERT IGNORE INTO owm_item (user_id, monster_id, item_id, amount, is_equipped, created_at, updated_at, fight_id, guild_id, map_id) VALUES (NULL, 16, 25, 0, 0, "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'", NULL, NULL, NULL)');
        $this->addSql('INSERT IGNORE INTO owm_item (user_id, monster_id, item_id, amount, is_equipped, created_at, updated_at, fight_id, guild_id, map_id) VALUES (NULL, 16, 24, 0, 0, "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'", NULL, NULL, NULL)');
        $this->addSql('INSERT IGNORE INTO owm_item (user_id, monster_id, item_id, amount, is_equipped, created_at, updated_at, fight_id, guild_id, map_id) VALUES (NULL, 16, 23, 0, 0, "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'", NULL, NULL, NULL)');
        $this->addSql('INSERT IGNORE INTO owm_item (user_id, monster_id, item_id, amount, is_equipped, created_at, updated_at, fight_id, guild_id, map_id) VALUES (NULL, 16, 22, 0, 0, "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'", NULL, NULL, NULL)');
        $this->addSql('INSERT IGNORE INTO owm_item (user_id, monster_id, item_id, amount, is_equipped, created_at, updated_at, fight_id, guild_id, map_id) VALUES (NULL, 16, 10, 0, 0, "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'", NULL, NULL, NULL)');
        $this->addSql('INSERT IGNORE INTO owm_item (user_id, monster_id, item_id, amount, is_equipped, created_at, updated_at, fight_id, guild_id, map_id) VALUES (NULL, 15, 12, 0, 0, "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'", NULL, NULL, NULL)');
        $this->addSql('INSERT IGNORE INTO owm_item (user_id, monster_id, item_id, amount, is_equipped, created_at, updated_at, fight_id, guild_id, map_id) VALUES (NULL, 15, 10, 0, 0, "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'", NULL, NULL, NULL)');
        $this->addSql('INSERT IGNORE INTO owm_item (user_id, monster_id, item_id, amount, is_equipped, created_at, updated_at, fight_id, guild_id, map_id) VALUES (NULL, 15, 21, 0, 0, "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'", NULL, NULL, NULL)');
        $this->addSql('INSERT IGNORE INTO owm_item (user_id, monster_id, item_id, amount, is_equipped, created_at, updated_at, fight_id, guild_id, map_id) VALUES (NULL, 15, 20, 0, 0, "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'", NULL, NULL, NULL)');
        $this->addSql('INSERT IGNORE INTO owm_item (user_id, monster_id, item_id, amount, is_equipped, created_at, updated_at, fight_id, guild_id, map_id) VALUES (NULL, 15, 25, 0, 0, "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'", NULL, NULL, NULL)');
        $this->addSql('INSERT IGNORE INTO owm_item (user_id, monster_id, item_id, amount, is_equipped, created_at, updated_at, fight_id, guild_id, map_id) VALUES (NULL, 15, 24, 0, 0, "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'", NULL, NULL, NULL)');
        $this->addSql('INSERT IGNORE INTO owm_item (user_id, monster_id, item_id, amount, is_equipped, created_at, updated_at, fight_id, guild_id, map_id) VALUES (NULL, 15, 23, 0, 0, "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'", NULL, NULL, NULL)');
        $this->addSql('INSERT IGNORE INTO owm_item (user_id, monster_id, item_id, amount, is_equipped, created_at, updated_at, fight_id, guild_id, map_id) VALUES (NULL, 15, 22, 0, 0, "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'", NULL, NULL, NULL)');
        $this->addSql('INSERT IGNORE INTO owm_item (user_id, monster_id, item_id, amount, is_equipped, created_at, updated_at, fight_id, guild_id, map_id) VALUES (NULL, 14, 25, 0, 0, "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'", NULL, NULL, NULL)');
        $this->addSql('INSERT IGNORE INTO owm_item (user_id, monster_id, item_id, amount, is_equipped, created_at, updated_at, fight_id, guild_id, map_id) VALUES (NULL, 14, 24, 0, 0, "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'", NULL, NULL, NULL)');
        $this->addSql('INSERT IGNORE INTO owm_item (user_id, monster_id, item_id, amount, is_equipped, created_at, updated_at, fight_id, guild_id, map_id) VALUES (NULL, 14, 23, 0, 0, "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'", NULL, NULL, NULL)');
        $this->addSql('INSERT IGNORE INTO owm_item (user_id, monster_id, item_id, amount, is_equipped, created_at, updated_at, fight_id, guild_id, map_id) VALUES (NULL, 14, 22, 0, 0, "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'", NULL, NULL, NULL)');
        $this->addSql('INSERT IGNORE INTO owm_item (user_id, monster_id, item_id, amount, is_equipped, created_at, updated_at, fight_id, guild_id, map_id) VALUES (NULL, 14, 10, 0, 0, "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'", NULL, NULL, NULL)');
        $this->addSql('INSERT IGNORE INTO owm_item (user_id, monster_id, item_id, amount, is_equipped, created_at, updated_at, fight_id, guild_id, map_id) VALUES (NULL, 13, 17, 0, 0, "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'", NULL, NULL, NULL)');
        $this->addSql('INSERT IGNORE INTO owm_item (user_id, monster_id, item_id, amount, is_equipped, created_at, updated_at, fight_id, guild_id, map_id) VALUES (NULL, 13, 16, 0, 0, "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'", NULL, NULL, NULL)');
        $this->addSql('INSERT IGNORE INTO owm_item (user_id, monster_id, item_id, amount, is_equipped, created_at, updated_at, fight_id, guild_id, map_id) VALUES (NULL, 13, 15, 0, 0, "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'", NULL, NULL, NULL)');
        $this->addSql('INSERT IGNORE INTO owm_item (user_id, monster_id, item_id, amount, is_equipped, created_at, updated_at, fight_id, guild_id, map_id) VALUES (NULL, 13, 14, 0, 0, "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'", NULL, NULL, NULL)');
        $this->addSql('INSERT IGNORE INTO owm_item (user_id, monster_id, item_id, amount, is_equipped, created_at, updated_at, fight_id, guild_id, map_id) VALUES (NULL, 13, 9, 0, 0, "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'", NULL, NULL, NULL)');
        $this->addSql('INSERT IGNORE INTO owm_item (user_id, monster_id, item_id, amount, is_equipped, created_at, updated_at, fight_id, guild_id, map_id) VALUES (NULL, 12, 17, 0, 0, "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'", NULL, NULL, NULL)');
        $this->addSql('INSERT IGNORE INTO owm_item (user_id, monster_id, item_id, amount, is_equipped, created_at, updated_at, fight_id, guild_id, map_id) VALUES (NULL, 12, 16, 0, 0, "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'", NULL, NULL, NULL)');
        $this->addSql('INSERT IGNORE INTO owm_item (user_id, monster_id, item_id, amount, is_equipped, created_at, updated_at, fight_id, guild_id, map_id) VALUES (NULL, 12, 15, 0, 0, "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'", NULL, NULL, NULL)');
        $this->addSql('INSERT IGNORE INTO owm_item (user_id, monster_id, item_id, amount, is_equipped, created_at, updated_at, fight_id, guild_id, map_id) VALUES (NULL, 12, 14, 0, 0, "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'", NULL, NULL, NULL)');
        $this->addSql('INSERT IGNORE INTO owm_item (user_id, monster_id, item_id, amount, is_equipped, created_at, updated_at, fight_id, guild_id, map_id) VALUES (NULL, 12, 9, 0, 0, "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'", NULL, NULL, NULL)');
        $this->addSql('INSERT IGNORE INTO owm_item (user_id, monster_id, item_id, amount, is_equipped, created_at, updated_at, fight_id, guild_id, map_id) VALUES (NULL, 4, 17, 0, 0, "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'", NULL, NULL, NULL)');
        $this->addSql('INSERT IGNORE INTO owm_item (user_id, monster_id, item_id, amount, is_equipped, created_at, updated_at, fight_id, guild_id, map_id) VALUES (NULL, 4, 16, 0, 0, "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'", NULL, NULL, NULL)');
        $this->addSql('INSERT IGNORE INTO owm_item (user_id, monster_id, item_id, amount, is_equipped, created_at, updated_at, fight_id, guild_id, map_id) VALUES (NULL, 4, 15, 0, 0, "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'", NULL, NULL, NULL)');
        $this->addSql('INSERT IGNORE INTO owm_item (user_id, monster_id, item_id, amount, is_equipped, created_at, updated_at, fight_id, guild_id, map_id) VALUES (NULL, 4, 14, 0, 0, "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'", NULL, NULL, NULL)');
        $this->addSql('INSERT IGNORE INTO owm_item (user_id, monster_id, item_id, amount, is_equipped, created_at, updated_at, fight_id, guild_id, map_id) VALUES (NULL, 4, 9, 0, 0, "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'", NULL, NULL, NULL)');
        $this->addSql('INSERT IGNORE INTO owm_item (user_id, monster_id, item_id, amount, is_equipped, created_at, updated_at, fight_id, guild_id, map_id) VALUES (NULL, 3, 18, 0, 0, "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'", NULL, NULL, NULL)');
        $this->addSql('INSERT IGNORE INTO owm_item (user_id, monster_id, item_id, amount, is_equipped, created_at, updated_at, fight_id, guild_id, map_id) VALUES (NULL, 3, 19, 0, 0, "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'", NULL, NULL, NULL)');
        $this->addSql('INSERT IGNORE INTO owm_item (user_id, monster_id, item_id, amount, is_equipped, created_at, updated_at, fight_id, guild_id, map_id) VALUES (NULL, 3, 15, 0, 0, "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'", NULL, NULL, NULL)');
        $this->addSql('INSERT IGNORE INTO owm_item (user_id, monster_id, item_id, amount, is_equipped, created_at, updated_at, fight_id, guild_id, map_id) VALUES (NULL, 3, 17, 0, 0, "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'", NULL, NULL, NULL)');
        $this->addSql('INSERT IGNORE INTO owm_item (user_id, monster_id, item_id, amount, is_equipped, created_at, updated_at, fight_id, guild_id, map_id) VALUES (NULL, 3, 9, 0, 0, "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'", NULL, NULL, NULL)');
        $this->addSql('INSERT IGNORE INTO owm_item (user_id, monster_id, item_id, amount, is_equipped, created_at, updated_at, fight_id, guild_id, map_id) VALUES (NULL, 3, 14, 0, 0, "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'", NULL, NULL, NULL)');
        $this->addSql('INSERT IGNORE INTO owm_item (user_id, monster_id, item_id, amount, is_equipped, created_at, updated_at, fight_id, guild_id, map_id) VALUES (NULL, 3, 16, 0, 0, "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'", NULL, NULL, NULL)');
        $this->addSql('INSERT IGNORE INTO owm_item (user_id, monster_id, item_id, amount, is_equipped, created_at, updated_at, fight_id, guild_id, map_id) VALUES (NULL, NULL, 4, 0, 0, "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'", NULL, NULL, 3)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
