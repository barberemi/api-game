<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200716143920 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE bind_characteristic (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, monster_id INT DEFAULT NULL, characteristic_id INT DEFAULT NULL, amount INT NOT NULL, type VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_5CCC1CBFA76ED395 (user_id), INDEX IDX_5CCC1CBFC5FF1223 (monster_id), INDEX IDX_5CCC1CBFDEE9D12B (characteristic_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bind_characteristic ADD CONSTRAINT FK_5CCC1CBFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE bind_characteristic ADD CONSTRAINT FK_5CCC1CBFC5FF1223 FOREIGN KEY (monster_id) REFERENCES monster (id)');
        $this->addSql('ALTER TABLE bind_characteristic ADD CONSTRAINT FK_5CCC1CBFDEE9D12B FOREIGN KEY (characteristic_id) REFERENCES characteristic (id)');
        $this->addSql('DROP TABLE monster_characteristic');
        $this->addSql('DROP TABLE user_characteristic');
        $this->addSql('ALTER TABLE skill CHANGE is_active is_active TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE monster_characteristic (id INT AUTO_INCREMENT NOT NULL, monster_id INT DEFAULT NULL, characteristic_id INT DEFAULT NULL, amount INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_9EA23348C5FF1223 (monster_id), INDEX IDX_9EA23348DEE9D12B (characteristic_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE user_characteristic (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, characteristic_id INT DEFAULT NULL, amount INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_39AA7609A76ED395 (user_id), INDEX IDX_39AA7609DEE9D12B (characteristic_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE monster_characteristic ADD CONSTRAINT FK_9EA23348C5FF1223 FOREIGN KEY (monster_id) REFERENCES monster (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE monster_characteristic ADD CONSTRAINT FK_9EA23348DEE9D12B FOREIGN KEY (characteristic_id) REFERENCES characteristic (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE user_characteristic ADD CONSTRAINT FK_39AA7609A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE user_characteristic ADD CONSTRAINT FK_39AA7609DEE9D12B FOREIGN KEY (characteristic_id) REFERENCES characteristic (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('DROP TABLE bind_characteristic');
        $this->addSql('ALTER TABLE skill CHANGE is_active is_active TINYINT(1) DEFAULT \'1\' NOT NULL');
    }
}
