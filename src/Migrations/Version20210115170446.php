<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210115170446 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE guild ADD monster_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE guild ADD CONSTRAINT FK_75407DABC5FF1223 FOREIGN KEY (monster_id) REFERENCES monster (id)');
        $this->addSql('CREATE INDEX IDX_75407DABC5FF1223 ON guild (monster_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE guild DROP FOREIGN KEY FK_75407DABC5FF1223');
        $this->addSql('DROP INDEX IDX_75407DABC5FF1223 ON guild');
        $this->addSql('ALTER TABLE guild DROP monster_id');
    }
}
