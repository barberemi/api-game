<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200911133424 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('INSERT INTO characteristic (name, description, created_at, updated_at) VALUES ("Vie", "Points de vie du personnage. Une fois tombé à zéro, le personnage est mort.", "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'")');
        $this->addSql('INSERT INTO characteristic (name, description, created_at, updated_at) VALUES ("Mana", "Points de mana du personnage. Permet d\'utiliser des compétences et de lancer des sorts. Une fois tombé à zéro il n\'est plus possible de lancer des sorts.", "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'")');
        $this->addSql('INSERT INTO characteristic (name, description, created_at, updated_at) VALUES ("Résistance physique", "Permet de réduire les dégats physique subit.", "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'")');
        $this->addSql('INSERT INTO characteristic (name, description, created_at, updated_at) VALUES ("Résistance magique", "Permet de réduire les dégats magique subit.", "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'")');
        $this->addSql('INSERT INTO characteristic (name, description, created_at, updated_at) VALUES ("Hâte", "Vitesse du personnage. L\'ordre des tours dans les combats est déterminé selon cette caractéristique.", "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'")');
        $this->addSql('INSERT INTO characteristic (name, description, created_at, updated_at) VALUES ("Intelligence", "Puissance magique du personnage. Plus vous avez de l\'intelligence, plus vos compétences magique infligent des dégats.", "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'")');
        $this->addSql('INSERT INTO characteristic (name, description, created_at, updated_at) VALUES ("Force", "Puissance physique du personnage. Plus vous avez de la force, plus vos compétences physique infligent des dégats.", "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'")');
        $this->addSql('INSERT INTO characteristic (name, description, created_at, updated_at) VALUES ("Confiance", "Permet de changer vos compétences en la lumière et l\'ombre.", "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'")');

    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
