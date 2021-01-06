<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210106140537 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE owm_item ADD fight_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE owm_item ADD CONSTRAINT FK_75503D47AC6657E4 FOREIGN KEY (fight_id) REFERENCES fight (id)');
        $this->addSql('CREATE INDEX IDX_75503D47AC6657E4 ON owm_item (fight_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE owm_item DROP FOREIGN KEY FK_75503D47AC6657E4');
        $this->addSql('DROP INDEX IDX_75503D47AC6657E4 ON owm_item');
        $this->addSql('ALTER TABLE owm_item DROP fight_id');
    }
}
