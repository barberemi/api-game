<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200912103230 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('INSERT INTO academy (name, description, created_at, updated_at) VALUES ("Guerrier", "Académie de combat au corps à corps, le guerrier est présent sur le champ de bataille pour infliger des dégats physique.", "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'")');
        $this->addSql('INSERT INTO academy (name, description, created_at, updated_at) VALUES ("Archer", "Académie de combat à distance, l\'archer est présent sur le champ de bataille pour infliger des dégats physique.", "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'")');
        $this->addSql('INSERT INTO academy (name, description, created_at, updated_at) VALUES ("Protecteur", "Académie de combat au corps à corps, le protecteur est présent sur le champ de bataille pour encaisser les dégats des ennemis et prendre le focus de ceux-ci.", "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'")');
        $this->addSql('INSERT INTO academy (name, description, created_at, updated_at) VALUES ("Mage", "Académie de combat à distance, le mage est présent sur le champ de bataille pour infliger des dégats magique et de zone.", "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'")');
        $this->addSql('INSERT INTO academy (name, description, created_at, updated_at) VALUES ("Prêtre", "Académie de soutien, le prêtre est présent sur le champ de bataille pour épauler ses collègues via des compétences de soin ou des buffs.", "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'")');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
