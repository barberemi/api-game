<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200610091500 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user_skill (user_id INT NOT NULL, skill_id INT NOT NULL, INDEX IDX_BCFF1F2FA76ED395 (user_id), INDEX IDX_BCFF1F2F5585C142 (skill_id), PRIMARY KEY(user_id, skill_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE monster_characteristic (id INT AUTO_INCREMENT NOT NULL, monster_id INT DEFAULT NULL, characteristic_id INT DEFAULT NULL, amount INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_9EA23348C5FF1223 (monster_id), INDEX IDX_9EA23348DEE9D12B (characteristic_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE monster (id INT AUTO_INCREMENT NOT NULL, academy_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_245EC6F45E237E06 (name), INDEX IDX_245EC6F46D55ACAB (academy_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE monster_skill (monster_id INT NOT NULL, skill_id INT NOT NULL, INDEX IDX_28C5D832C5FF1223 (monster_id), INDEX IDX_28C5D8325585C142 (skill_id), PRIMARY KEY(monster_id, skill_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_skill ADD CONSTRAINT FK_BCFF1F2FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_skill ADD CONSTRAINT FK_BCFF1F2F5585C142 FOREIGN KEY (skill_id) REFERENCES skill (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE monster_characteristic ADD CONSTRAINT FK_9EA23348C5FF1223 FOREIGN KEY (monster_id) REFERENCES monster (id)');
        $this->addSql('ALTER TABLE monster_characteristic ADD CONSTRAINT FK_9EA23348DEE9D12B FOREIGN KEY (characteristic_id) REFERENCES characteristic (id)');
        $this->addSql('ALTER TABLE monster ADD CONSTRAINT FK_245EC6F46D55ACAB FOREIGN KEY (academy_id) REFERENCES academy (id)');
        $this->addSql('ALTER TABLE monster_skill ADD CONSTRAINT FK_28C5D832C5FF1223 FOREIGN KEY (monster_id) REFERENCES monster (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE monster_skill ADD CONSTRAINT FK_28C5D8325585C142 FOREIGN KEY (skill_id) REFERENCES skill (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE monster_characteristic DROP FOREIGN KEY FK_9EA23348C5FF1223');
        $this->addSql('ALTER TABLE monster_skill DROP FOREIGN KEY FK_28C5D832C5FF1223');
        $this->addSql('DROP TABLE user_skill');
        $this->addSql('DROP TABLE monster_characteristic');
        $this->addSql('DROP TABLE monster');
        $this->addSql('DROP TABLE monster_skill');
    }
}
