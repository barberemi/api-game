<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220922124801 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('INSERT IGNORE INTO map (id, name, level_min, created_at, updated_at, nb_floors, image) VALUES (3, "La forez trankil", 0, "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'", 10, "forest-thumbnail.jpg")');
        $this->addSql('INSERT IGNORE INTO map (id, name, level_min, created_at, updated_at, nb_floors, image) VALUES (4, "Le marez puan", 5, "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'", 10, "swamp-thumbnail.jpg")');
        $this->addSql('INSERT IGNORE INTO map (id, name, level_min, created_at, updated_at, nb_floors, image) VALUES (5, "Le dézer sableu", 30, "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'", 10, "desert-thumbnail.jpg")');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
