<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220922140212 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('INSERT IGNORE INTO skill (id, name, description, cooldown, duration, created_at, updated_at, academy_id, tree_type, type, amount, level, rate, scale_type, image) VALUES (8, "Frappe assommante", "Pendant 2 tour, cette attaque inflige #MONTANT# points de dégâts", 5, 2, "2020-10-02 13:54:09", "2021-06-15 11:25:32", 7, "light", "dot", 0, 5, 0.65, "strength", "SpellBookPreface_20.png")');
        $this->addSql('INSERT IGNORE INTO skill (id, name, description, cooldown, duration, created_at, updated_at, academy_id, tree_type, type, amount, level, rate, scale_type, image) VALUES (9, "Défense du gladiateur", "Pendant 3 tours, vous gagnez #MONTANT# points de vie", 9, 3, "2020-10-02 13:54:38", "2021-06-15 11:16:20", 7, "light", "hot", 0, 9, 0.03, "health", "SpellBookPreface_16.png")');
        $this->addSql('INSERT IGNORE INTO skill (id, name, description, cooldown, duration, created_at, updated_at, academy_id, tree_type, type, amount, level, rate, scale_type, image) VALUES (10, "Entaille", "Cette attaque inflige #MONTANT# points de dégâts", 0, 0, "2020-10-06 11:02:28", "2021-06-15 10:40:48", 7, "light", "melee", 0, 1, 1, "strength", "SpellBookPreface_20.png")');
        $this->addSql('INSERT IGNORE INTO skill (id, name, description, cooldown, duration, created_at, updated_at, academy_id, tree_type, type, amount, level, rate, scale_type, image) VALUES (15, "Taillage sauvage", "Cette attaque inflige #MONTANT# points de dégâts", 3, 0, "2020-11-30 19:19:35", "2021-06-15 10:50:06", 7, "light", "melee", 0, 7, 1.2, "strength", "SpellBookPreface_17.png")');
        $this->addSql('INSERT IGNORE INTO skill (id, name, description, cooldown, duration, created_at, updated_at, academy_id, tree_type, type, amount, level, rate, scale_type, image) VALUES (16, "Tranche-artère", "Cette attaque inflige #MONTANT# points de dégâts", 4, 0, "2020-11-30 19:20:56", "2021-06-15 11:27:08", 7, "light", "melee", 0, 13, 1.35, "strength", "SpellBookPreface_17.png")');
        $this->addSql('INSERT IGNORE INTO skill (id, name, description, cooldown, duration, created_at, updated_at, academy_id, tree_type, type, amount, level, rate, scale_type, image) VALUES (17, "Entaille critique", "Pendant 3 tours, cette attaque inflige #MONTANT# points de dégâts", 6, 3, "2020-11-30 19:37:40", "2021-06-15 14:27:53", 7, "light", "dot", 0, 15, 0.5, "strength", "SpellBookPreface_20.png")');
        $this->addSql('INSERT IGNORE INTO skill (id, name, description, cooldown, duration, created_at, updated_at, academy_id, tree_type, type, amount, level, rate, scale_type, image) VALUES (18, "Brise casque", "Coup écrasant faisant #MONTANT# de dégats", 5, 0, "2020-11-30 20:07:37", "2021-06-15 10:50:59", 7, "light", "melee", 0, 3, 1.3, "strength", "SpellBookPreface_19.png")');
        $this->addSql('INSERT IGNORE INTO skill (id, name, description, cooldown, duration, created_at, updated_at, academy_id, tree_type, type, amount, level, rate, scale_type, image) VALUES (19, "Pose défensive", "Vous gagnez #MONTANT# points de vie", 10, 0, "2020-11-30 20:08:45", "2021-06-15 11:15:38", 7, "light", "heal", 0, 2, 0.1, "health", "SpellBookPreface_16.png")');
        $this->addSql('INSERT IGNORE INTO skill (id, name, description, cooldown, duration, created_at, updated_at, academy_id, tree_type, type, amount, level, rate, scale_type, image) VALUES (20, "Tir", "Cette attaque inflige #MONTANT# points de dégâts", 0, 0, "2021-06-15 11:07:24", "2021-06-15 11:07:24", 8, "light", "range", 0, 1, 1, "agility", "SpellBookPreface_17.png")');
        $this->addSql('INSERT IGNORE INTO skill (id, name, description, cooldown, duration, created_at, updated_at, academy_id, tree_type, type, amount, level, rate, scale_type, image) VALUES (21, "Guérison de la nature", "Vous gagnez #MONTANT# points de vie", 10, 0, "2021-06-15 11:10:37", "2021-06-15 11:10:37", 8, "light", "heal", 0, 2, 0.1, "health", "SpellBookPreface_12.png")');
        $this->addSql('INSERT IGNORE INTO skill (id, name, description, cooldown, duration, created_at, updated_at, academy_id, tree_type, type, amount, level, rate, scale_type, image) VALUES (22, "Ronces", "Pendant 2 tours, cette attaque inflige #MONTANT# points de dégâts", 5, 2, "2021-06-15 11:19:42", "2021-06-15 11:30:00", 8, "light", "dot", 0, 5, 0.65, "agility", "SpellBookPreface_15.png")');
        $this->addSql('INSERT IGNORE INTO skill (id, name, description, cooldown, duration, created_at, updated_at, academy_id, tree_type, type, amount, level, rate, scale_type, image) VALUES (23, "Tir de précision", "Cette attaque inflige #MONTANT# points de dégâts", 5, 0, "2021-06-15 11:28:56", "2021-06-15 11:30:36", 8, "light", "range", 0, 3, 1.3, "agility", "SpellBookPreface_23.png")');
        $this->addSql('INSERT IGNORE INTO skill (id, name, description, cooldown, duration, created_at, updated_at, academy_id, tree_type, type, amount, level, rate, scale_type, image) VALUES (24, "Tir Puissant", "Cette attaque inflige #MONTANT# points de dégâts", 3, 0, "2021-06-15 11:31:51", "2021-06-15 11:31:51", 8, "light", "range", 0, 7, 1.2, "agility", "SpellBookPreface_19.png")');
        $this->addSql('INSERT IGNORE INTO skill (id, name, description, cooldown, duration, created_at, updated_at, academy_id, tree_type, type, amount, level, rate, scale_type, image) VALUES (25, "Bienfaits de la nature", "Pendant 3 tours, vous gagnez #MONTANT# points de vie", 9, 3, "2021-06-15 11:34:09", "2021-06-15 11:34:09", 8, "light", "heal", 0, 9, 0.03, "health", "SpellBookPreface_12.png")');
        $this->addSql('INSERT IGNORE INTO skill (id, name, description, cooldown, duration, created_at, updated_at, academy_id, tree_type, type, amount, level, rate, scale_type, image) VALUES (26, "Tir double", "Cette attaque inflige #MONTANT# points de dégâts", 4, 0, "2021-06-15 11:35:15", "2021-06-15 11:35:15", 8, "light", "range", 0, 12, 1.35, "agility", "SpellBookPreface_22.png")');
        $this->addSql('INSERT IGNORE INTO skill (id, name, description, cooldown, duration, created_at, updated_at, academy_id, tree_type, type, amount, level, rate, scale_type, image) VALUES (27, "Piège du trappeur", "Pendant 3 tours, cette attaque inflige #MONTANT# points de dégâts", 6, 3, "2021-06-15 11:37:45", "2021-06-15 11:37:45", 8, "light", "dot", 0, 15, 0.05, "agility", "SpellBookPreface_15.png")');
        $this->addSql('INSERT IGNORE INTO skill (id, name, description, cooldown, duration, created_at, updated_at, academy_id, tree_type, type, amount, level, rate, scale_type, image) VALUES (28, "Flammes", "Cette attaque inflige #MONTANT# points de dégâts", 0, 0, "2021-06-15 11:41:30", "2021-06-15 11:41:30", 10, "light", "range", 0, 1, 1, "intelligence", "SpellBookPreface_21.png")');
        $this->addSql('INSERT IGNORE INTO skill (id, name, description, cooldown, duration, created_at, updated_at, academy_id, tree_type, type, amount, level, rate, scale_type, image) VALUES (29, "Guérison", "Vous gagnez #MONTANT# points de vie", 10, 0, "2021-06-15 11:48:22", "2021-06-15 11:48:50", 10, "light", "heal", 0, 2, 1.2, "intelligence", "SpellBookPreface_12.png")');
        $this->addSql('INSERT IGNORE INTO skill (id, name, description, cooldown, duration, created_at, updated_at, academy_id, tree_type, type, amount, level, rate, scale_type, image) VALUES (30, "Boule de feu", "Cette attaque inflige #MONTANT# points de dégâts", 5, 0, "2021-06-15 11:49:43", "2021-06-15 11:49:43", 10, "light", "range", 0, 3, 1.3, "intelligence", "SpellBookPreface_18.png")');
        $this->addSql('INSERT IGNORE INTO skill (id, name, description, cooldown, duration, created_at, updated_at, academy_id, tree_type, type, amount, level, rate, scale_type, image) VALUES (31, "Blizzard", "Pendant 2 tours, cette attaque inflige #MONTANT# points de dégâts", 5, 2, "2021-06-15 11:51:07", "2021-06-15 11:51:50", 10, "light", "dot", 0, 5, 0.65, "intelligence", "SpellBookPreface_09.png")');
        $this->addSql('INSERT IGNORE INTO skill (id, name, description, cooldown, duration, created_at, updated_at, academy_id, tree_type, type, amount, level, rate, scale_type, image) VALUES (32, "Pic de glace", "Cette attaque inflige #MONTANT# points de dégâts", 3, 0, "2021-06-15 11:53:57", "2021-06-15 11:53:57", 10, "light", "range", 0, 7, 1.2, "intelligence", "SpellBookPreface_05.png")');
        $this->addSql('INSERT IGNORE INTO skill (id, name, description, cooldown, duration, created_at, updated_at, academy_id, tree_type, type, amount, level, rate, scale_type, image) VALUES (33, "Restauration", "Pendant 3 tours, Cette gagnez #MONTANT# points de vie", 9, 3, "2021-06-15 11:55:52", "2021-06-15 11:55:52", 10, "light", "hot", 0, 9, 0.03, "intelligence", "SpellBookPreface_12.png")');
        $this->addSql('INSERT IGNORE INTO skill (id, name, description, cooldown, duration, created_at, updated_at, academy_id, tree_type, type, amount, level, rate, scale_type, image) VALUES (34, "Météore", "Cette attaque inflige #MONTANT# points de dégâts", 4, 0, "2021-06-15 11:57:24", "2021-06-15 11:57:24", 10, "light", "range", 0, 12, 1.35, "intelligence", "SpellBookPreface_18.png")');
        $this->addSql('INSERT IGNORE INTO skill (id, name, description, cooldown, duration, created_at, updated_at, academy_id, tree_type, type, amount, level, rate, scale_type, image) VALUES (35, "Tempête de feu", "Pendant 3 tours, cette attaque inflige #MONTANT# points de dégâts", 6, 3, "2021-06-15 11:59:01", "2021-06-15 11:59:01", 10, "light", "dot", 0, 15, 0.5, "intelligence", "SpellBookPreface_21.png")');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
