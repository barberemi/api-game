<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220922155212 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // Ajouter des buildings / Inserer ceux déjà existants
        $this->addSql('INSERT IGNORE INTO building (id, parent_id, name, label, type, description, is_user_building, needed_actions, needed_materials, created_at, updated_at, amount) VALUES (1, NULL, "wall", "Mur", "defense", "Mur de la maison personnelle.", 1, 10, 10, "' . date_create()->format('Y-m-d H:i:s') . '", "' . date_create()->format('Y-m-d H:i:s') . '", 1)');
        $this->addSql('INSERT IGNORE INTO building (id, parent_id, name, label, type, description, is_user_building, needed_actions, needed_materials, created_at, updated_at, amount) VALUES (2, 1, "roof", "Toiture", "defense", "Toiture de la maison personnelle.", 1, 10, 10, "' . date_create()->format('Y-m-d H:i:s') . '", "' . date_create()->format('Y-m-d H:i:s') . '", 2)');
        $this->addSql('INSERT IGNORE INTO building (id, parent_id, name, label, type, description, is_user_building, needed_actions, needed_materials, created_at, updated_at, amount) VALUES (3, 2, "box", "Coffre", "user_bag", "Coffre de la maison personnelle permettant d\'augmenter le nombre max d\'objets que vous pouvez porter.", 1, 10, 10, "' . date_create()->format('Y-m-d H:i:s') . '", "' . date_create()->format('Y-m-d H:i:s') . '", 5)');
        $this->addSql('INSERT IGNORE INTO building (id, parent_id, name, label, type, description, is_user_building, needed_actions, needed_materials, created_at, updated_at, amount) VALUES (4, NULL, "wall-guild", "Mur de la guilde", "defense", "Mur de la guilde.", 0, 10, 10, "' . date_create()->format('Y-m-d H:i:s') . '", "' . date_create()->format('Y-m-d H:i:s') . '", 1)');
        $this->addSql('INSERT IGNORE INTO building (id, parent_id, name, label, type, description, is_user_building, needed_actions, needed_materials, created_at, updated_at, amount) VALUES (5, 4, "roof-guild", "Toiture de guilde", "defense", "Toiture de la maison de la guilde.", 0, 10, 10, "' . date_create()->format('Y-m-d H:i:s') . '", "' . date_create()->format('Y-m-d H:i:s') . '", 2)');
        $this->addSql('INSERT IGNORE INTO building (id, parent_id, name, label, type, description, is_user_building, needed_actions, needed_materials, created_at, updated_at, amount) VALUES (6, 5, "box-guild", "Coffre de guilde", "user_bag", "Coffre de la guilde permettant d\'augmenter le nombre max d\'objets que chaque membre de la guilde peut porter.", 0, 20, 20, "' . date_create()->format('Y-m-d H:i:s') . '", "' . date_create()->format('Y-m-d H:i:s') . '", 5)');
        $this->addSql('INSERT IGNORE INTO building (id, parent_id, name, label, type, description, is_user_building, needed_actions, needed_materials, created_at, updated_at, amount) VALUES (7, 5, "wood-spoon-guild", "Cuillère en bois de guilde", "action", "Cuillère en bois de la guilde permettant d\'augmenter de nombre d\'actions que chaque membre de la guilde peut effectuer par jour.", 0, 30, 30, "' . date_create()->format('Y-m-d H:i:s') . '", "' . date_create()->format('Y-m-d H:i:s') . '", 1)');

        // Constructions user (me only)
        $this->addSql('INSERT INTO construction (guild_id, user_id, building_id, remaining_actions, remaining_materials, created_at, updated_at, status) VALUES (NULL, 1, 1, 10, 10, "' . date_create()->format('Y-m-d H:i:s') . '", "' . date_create()->format('Y-m-d H:i:s') . '", "in_progress")');
        $this->addSql('INSERT INTO construction (guild_id, user_id, building_id, remaining_actions, remaining_materials, created_at, updated_at, status) VALUES (NULL, 1, 2, 10, 10, "' . date_create()->format('Y-m-d H:i:s') . '", "' . date_create()->format('Y-m-d H:i:s') . '", "in_progress")');
        $this->addSql('INSERT INTO construction (guild_id, user_id, building_id, remaining_actions, remaining_materials, created_at, updated_at, status) VALUES (NULL, 1, 3, 10, 10, "' . date_create()->format('Y-m-d H:i:s') . '", "' . date_create()->format('Y-m-d H:i:s') . '", "in_progress")');


        // MAJ de la description des jobs
        $this->addSql('UPDATE job SET description = "Le défenseur apporte le double de défense pour la guilde." WHERE name = "defender"');
        $this->addSql('UPDATE job SET description = "Le mineur peut utiliser sa compétence 1 fois/jour afin de trouver des matériaux." WHERE name = "minor"');
        $this->addSql('UPDATE job SET description = "L’ingénieur possède +1 point d\'action par jour." WHERE name = "engineer"');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
