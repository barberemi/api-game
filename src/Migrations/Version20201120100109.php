<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201120100109 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        // Add fields
        $this->addSql('ALTER TABLE academy ADD label VARCHAR(255), ADD color VARCHAR(255), ADD role VARCHAR(255)');

        // Default datas
        $this->addSql('UPDATE academy SET color = "#dc3545", label = name, role = "Dégats physiques,Corps à corps" WHERE name = "Guerrier"');
        $this->addSql('UPDATE academy SET color = "#ec9b3b", label = name, role = "Dégats physiques,Distance" WHERE name = "Archer"');
        $this->addSql('UPDATE academy SET color = "#007bff", label = name, role = "Dégats magiques,Distance" WHERE name = "Mage"');
        $this->addSql('UPDATE academy SET color = "#28a745", label = name, role = "Encaisser les dégats,Corps à corps" WHERE name = "Protecteur"');
        $this->addSql('UPDATE academy SET color = "#28a745", label = name, role = "Soutien,Soin" WHERE name = "Prêtre"');
        $this->addSql('UPDATE academy SET name = "warrior" WHERE label = "Guerrier"');
        $this->addSql('UPDATE academy SET name = "hunter" WHERE label = "Archer"');
        $this->addSql('UPDATE academy SET name = "magician" WHERE label = "Mage"');
        $this->addSql('UPDATE academy SET name = "protector" WHERE label = "Protecteur"');
        $this->addSql('UPDATE academy SET name = "priest" WHERE label = "Prêtre"');


        // Constraint NOT NULL
        $this->addSql('ALTER TABLE academy MODIFY label VARCHAR(255) NOT NULL, MODIFY color VARCHAR(255) NOT NULL, MODIFY role VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

//        $this->addSql('ALTER TABLE academy DROP label, DROP color, DROP role');
    }
}
