<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221004145504 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE season (id INT AUTO_INCREMENT NOT NULL, is_rewarded TINYINT(1) NOT NULL, starting_at DATE DEFAULT NULL, ending_at DATE DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE owm_item ADD season_reward1_id INT DEFAULT NULL, ADD season_reward2_id INT DEFAULT NULL, ADD season_reward3_id INT DEFAULT NULL, ADD season_reward4_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE owm_item ADD CONSTRAINT FK_75503D47476715E6 FOREIGN KEY (season_reward1_id) REFERENCES season (id)');
        $this->addSql('ALTER TABLE owm_item ADD CONSTRAINT FK_75503D4755D2BA08 FOREIGN KEY (season_reward2_id) REFERENCES season (id)');
        $this->addSql('ALTER TABLE owm_item ADD CONSTRAINT FK_75503D47ED6EDD6D FOREIGN KEY (season_reward3_id) REFERENCES season (id)');
        $this->addSql('ALTER TABLE owm_item ADD CONSTRAINT FK_75503D4770B9E5D4 FOREIGN KEY (season_reward4_id) REFERENCES season (id)');
        $this->addSql('CREATE INDEX IDX_75503D47476715E6 ON owm_item (season_reward1_id)');
        $this->addSql('CREATE INDEX IDX_75503D4755D2BA08 ON owm_item (season_reward2_id)');
        $this->addSql('CREATE INDEX IDX_75503D47ED6EDD6D ON owm_item (season_reward3_id)');
        $this->addSql('CREATE INDEX IDX_75503D4770B9E5D4 ON owm_item (season_reward4_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE owm_item DROP FOREIGN KEY FK_75503D47476715E6');
        $this->addSql('ALTER TABLE owm_item DROP FOREIGN KEY FK_75503D4755D2BA08');
        $this->addSql('ALTER TABLE owm_item DROP FOREIGN KEY FK_75503D47ED6EDD6D');
        $this->addSql('ALTER TABLE owm_item DROP FOREIGN KEY FK_75503D4770B9E5D4');
        $this->addSql('DROP TABLE season');
        $this->addSql('DROP INDEX IDX_75503D47476715E6 ON owm_item');
        $this->addSql('DROP INDEX IDX_75503D4755D2BA08 ON owm_item');
        $this->addSql('DROP INDEX IDX_75503D47ED6EDD6D ON owm_item');
        $this->addSql('DROP INDEX IDX_75503D4770B9E5D4 ON owm_item');
        $this->addSql('ALTER TABLE owm_item DROP season_reward1_id, DROP season_reward2_id, DROP season_reward3_id, DROP season_reward4_id');
    }
}
