<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200716145209 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE bind_characteristic ADD skill_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE bind_characteristic ADD CONSTRAINT FK_5CCC1CBF5585C142 FOREIGN KEY (skill_id) REFERENCES skill (id)');
        $this->addSql('CREATE INDEX IDX_5CCC1CBF5585C142 ON bind_characteristic (skill_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE bind_characteristic DROP FOREIGN KEY FK_5CCC1CBF5585C142');
        $this->addSql('DROP INDEX IDX_5CCC1CBF5585C142 ON bind_characteristic');
        $this->addSql('ALTER TABLE bind_characteristic DROP skill_id');
    }
}
