<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210129131312 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE owm_item ADD map_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE owm_item ADD CONSTRAINT FK_75503D4753C55F64 FOREIGN KEY (map_id) REFERENCES map (id)');
        $this->addSql('CREATE INDEX IDX_75503D4753C55F64 ON owm_item (map_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE owm_item DROP FOREIGN KEY FK_75503D4753C55F64');
        $this->addSql('DROP INDEX IDX_75503D4753C55F64 ON owm_item');
        $this->addSql('ALTER TABLE owm_item DROP map_id');
    }
}
