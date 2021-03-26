<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210326160503 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE building (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, label VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, is_user_building TINYINT(1) NOT NULL, needed_actions INT NOT NULL, needed_materials JSON DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_E16F61D45E237E06 (name), INDEX IDX_E16F61D4727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE construction (id INT AUTO_INCREMENT NOT NULL, guild_id INT DEFAULT NULL, user_id INT DEFAULT NULL, building_id INT DEFAULT NULL, remaining_actions INT NOT NULL, remaining_materials JSON DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_DC91E26E5F2131EF (guild_id), INDEX IDX_DC91E26EA76ED395 (user_id), INDEX IDX_DC91E26E4D2A7E12 (building_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE building ADD CONSTRAINT FK_E16F61D4727ACA70 FOREIGN KEY (parent_id) REFERENCES building (id)');
        $this->addSql('ALTER TABLE construction ADD CONSTRAINT FK_DC91E26E5F2131EF FOREIGN KEY (guild_id) REFERENCES guild (id)');
        $this->addSql('ALTER TABLE construction ADD CONSTRAINT FK_DC91E26EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE construction ADD CONSTRAINT FK_DC91E26E4D2A7E12 FOREIGN KEY (building_id) REFERENCES building (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE building DROP FOREIGN KEY FK_E16F61D4727ACA70');
        $this->addSql('ALTER TABLE construction DROP FOREIGN KEY FK_DC91E26E4D2A7E12');
        $this->addSql('DROP TABLE building');
        $this->addSql('DROP TABLE construction');
    }
}
