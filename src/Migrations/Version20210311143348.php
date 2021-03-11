<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210311143348 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE academy ADD label_dark VARCHAR(255) NOT NULL, CHANGE label label_light VARCHAR(255) NOT NULL');
        $this->addSql('UPDATE academy SET label_light = "Guerrier de lumière", label_dark = "Guerrier des ombres" WHERE label_light = "Guerrier"');
        $this->addSql('UPDATE academy SET label_light = "Mage de lumière", label_dark = "Mage des ombres" WHERE label_light = "Mage"');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE academy ADD label VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, DROP label_light, DROP label_dark');
    }
}
