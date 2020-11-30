<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201123131822 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE crafting (id INT AUTO_INCREMENT NOT NULL, item_to_craft_id INT DEFAULT NULL, item_needed_to_craft_id INT DEFAULT NULL, amount INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_1E989297C5070A50 (item_to_craft_id), INDEX IDX_1E98929778CCE3A (item_needed_to_craft_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE crafting ADD CONSTRAINT FK_1E989297C5070A50 FOREIGN KEY (item_to_craft_id) REFERENCES item (id)');
        $this->addSql('ALTER TABLE crafting ADD CONSTRAINT FK_1E98929778CCE3A FOREIGN KEY (item_needed_to_craft_id) REFERENCES item (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE crafting');
    }
}
