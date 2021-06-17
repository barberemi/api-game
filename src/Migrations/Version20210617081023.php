<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210617081023 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE academy ADD label VARCHAR(255) NOT NULL, DROP label_light, DROP label_dark');
        $this->addSql('DELETE FROM academy WHERE name = "priest"');
        $this->addSql('DELETE FROM academy WHERE name = "protector"');
        $this->addSql('UPDATE academy SET label = "Guerrier" WHERE name = "warrior"');
        $this->addSql('UPDATE academy SET label = "Archer", color="#28a745" WHERE name = "hunter"');
        $this->addSql('UPDATE academy SET label = "Magicien" WHERE name = "magician"');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE academy ADD label_dark VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE label label_light VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
