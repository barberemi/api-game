<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210413082426 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE building CHANGE needed_materials needed_materials INT DEFAULT NULL');
        $this->addSql('ALTER TABLE construction CHANGE remaining_materials remaining_materials INT DEFAULT NULL');
        $this->addSql('UPDATE construction SET remaining_materials = 10');
        $this->addSql('UPDATE building SET needed_materials = 10');
        $this->addSql('ALTER TABLE building CHANGE needed_materials needed_materials INT NOT NULL');
        $this->addSql('ALTER TABLE construction CHANGE remaining_materials remaining_materials INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE building CHANGE needed_materials needed_materials JSON DEFAULT NULL');
        $this->addSql('ALTER TABLE construction CHANGE remaining_materials remaining_materials JSON DEFAULT NULL');
    }
}
