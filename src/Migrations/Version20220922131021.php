<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220922131021 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('INSERT IGNORE INTO item (id, name, cost, level, drop_rate, created_at, updated_at, rarity, type, image) VALUES  (8, "Bois", 1, 1, 100, "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'", "commun", "craft", "craft/wood.png")');
		$this->addSql('INSERT IGNORE INTO item (id, name, cost, level, drop_rate, created_at, updated_at, rarity, type, image) VALUES (9, "Épée en fer", 100, 2, 2, "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'", "common", "weapon", "weapon/basic-sword.png")');
		$this->addSql('INSERT IGNORE INTO item (id, name, cost, level, drop_rate, created_at, updated_at, rarity, type, image) VALUES (10, "Epée en acier", 100, 8, 2, "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'", "common", "weapon", "weapon/manticor-sword.png")');
		$this->addSql('INSERT IGNORE INTO item (id, name, cost, level, drop_rate, created_at, updated_at, rarity, type, image) VALUES (11, "Epée nordique", 100, 12, 2, "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'", "common", "weapon", "weapon/mountain-sword.png")');
		$this->addSql('INSERT IGNORE INTO item (id, name, cost, level, drop_rate, created_at, updated_at, rarity, type, image) VALUES (12, "Hache en acier", 100, 9, 15, "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'", "unusual", "weapon", "weapon/basic-axe.png")');
		$this->addSql('INSERT IGNORE INTO item (id, name, cost, level, drop_rate, created_at, updated_at, rarity, type, image) VALUES (13, "Epée elfique", 100, 14, 10, "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'", "rare", "weapon", "weapon/great-sword.png")');
		$this->addSql('INSERT IGNORE INTO item (id, name, cost, level, drop_rate, created_at, updated_at, rarity, type, image) VALUES (14, "Casque en fer", 100, 3, 2, "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'", "common", "helmet", "helmet/knight.png")');
		$this->addSql('INSERT IGNORE INTO item (id, name, cost, level, drop_rate, created_at, updated_at, rarity, type, image) VALUES (15, "Armure en fer", 100, 4, 2, "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'", "common", "armor", "armor/knight.png")');
		$this->addSql('INSERT IGNORE INTO item (id, name, cost, level, drop_rate, created_at, updated_at, rarity, type, image) VALUES (16, "Gantelet en fer", 100, 2, 2, "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'", "common", "glovers", "glovers/knight.png")');
		$this->addSql('INSERT IGNORE INTO item (id, name, cost, level, drop_rate, created_at, updated_at, rarity, type, image) VALUES (17, "Bottes en fer", 100, 2, 2, "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'", "common", "shoes", "shoes/knight.png")');
		$this->addSql('INSERT IGNORE INTO item (id, name, cost, level, drop_rate, created_at, updated_at, rarity, type, image) VALUES (18, "Gantelet antique", 100, 4, 15, "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'", "unusual", "helmet", "glovers/mountain.png")');
		$this->addSql('INSERT IGNORE INTO item (id, name, cost, level, drop_rate, created_at, updated_at, rarity, type, image) VALUES (19, "Bottes antiques", 100, 4, 15, "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'", "unusual", "shoes", "shoes/mountain.png")');
		$this->addSql('INSERT IGNORE INTO item (id, name, cost, level, drop_rate, created_at, updated_at, rarity, type, image) VALUES (20, "Armure antique", 100, 8, 15, "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'", "rare", "armor", "armor/mountain.png")');
		$this->addSql('INSERT IGNORE INTO item (id, name, cost, level, drop_rate, created_at, updated_at, rarity, type, image) VALUES (21, "Casque antique", 100, 9, 15, "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'", "rare", "helmet", "helmet/mountain.png")');
		$this->addSql('INSERT IGNORE INTO item (id, name, cost, level, drop_rate, created_at, updated_at, rarity, type, image) VALUES (22, "Casque en acier", 100, 8, 2, "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'", "common", "helmet", "helmet/knight.png")');
		$this->addSql('INSERT IGNORE INTO item (id, name, cost, level, drop_rate, created_at, updated_at, rarity, type, image) VALUES (23, "Armure en acier", 100, 7, 2, "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'", "common", "armor", "armor/knight.png")');
		$this->addSql('INSERT IGNORE INTO item (id, name, cost, level, drop_rate, created_at, updated_at, rarity, type, image) VALUES (24, "Gantelet en acier", 100, 6, 2, "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'", "common", "glovers", "glovers/knight.png")');
		$this->addSql('INSERT IGNORE INTO item (id, name, cost, level, drop_rate, created_at, updated_at, rarity, type, image) VALUES (25, "Bottes en acier", 100, 9, 2, "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'", "common", "shoes", "shoes/knight.png")');

    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
