<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201123092954 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE owm_item (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, monster_id INT DEFAULT NULL, item_id INT DEFAULT NULL, amount INT NOT NULL, is_equipped TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_75503D47A76ED395 (user_id), INDEX IDX_75503D47C5FF1223 (monster_id), INDEX IDX_75503D47126F525E (item_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE owm_item ADD CONSTRAINT FK_75503D47A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE owm_item ADD CONSTRAINT FK_75503D47C5FF1223 FOREIGN KEY (monster_id) REFERENCES monster (id)');
        $this->addSql('ALTER TABLE owm_item ADD CONSTRAINT FK_75503D47126F525E FOREIGN KEY (item_id) REFERENCES item (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE owm_item');
    }
}
