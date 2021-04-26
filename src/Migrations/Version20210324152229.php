<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210324152229 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE job (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, label VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_FBD8E0F85E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user ADD job_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649BE04EA9 FOREIGN KEY (job_id) REFERENCES job (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649BE04EA9 ON user (job_id)');

        // INSERT JOBS
        $this->addSql('INSERT INTO job (id, name, label, description, created_at, updated_at) VALUES (1, "villager", "Villageois", "Habitant de la ville, rien de plus, ni moins.", "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'")');
        $this->addSql('INSERT INTO job (id, name, label, description, created_at, updated_at) VALUES (2, "defender", "Défenseur", "Le défenseur apporte plus de défense dans la ville.", "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'")');
        $this->addSql('INSERT INTO job (id, name, label, description, created_at, updated_at) VALUES (3, "minor", "Mineur", "Le mineur peut utiliser une pelle lors de ses explorations afin d’y trouver des matériaux.", "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'")');
        $this->addSql('INSERT INTO job (id, name, label, description, created_at, updated_at) VALUES (4, "engineer", "Ingénieur", "L’ingénieur peut effectuer une action en plus par jour.", "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'")');
        $this->addSql('INSERT INTO job (id, name, label, description, created_at, updated_at) VALUES (5, "scout", "Scout", "Le scout peut tenter d’estimer le nombre d’ennemis qui viendront à la prochaine attaque.", "'.date_create()->format('Y-m-d H:i:s').'", "'.date_create()->format('Y-m-d H:i:s').'")');

        // UPDATE USERS
        $this->addSql('UPDATE user SET job_id = 1');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649BE04EA9');
        $this->addSql('DROP TABLE job');
        $this->addSql('DROP INDEX IDX_8D93D649BE04EA9 ON user');
        $this->addSql('ALTER TABLE user DROP job_id');
    }
}
