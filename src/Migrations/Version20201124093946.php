<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201124093946 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('ALTER TABLE characteristic ADD label VARCHAR(255) NOT NULL');
        $this->addSql('UPDATE characteristic SET label = name WHERE name = "Vie"');
        $this->addSql('UPDATE characteristic SET name = "health" WHERE name = "Vie"');
        $this->addSql('UPDATE characteristic SET label = name WHERE name = "Force"');
        $this->addSql('UPDATE characteristic SET name = "strength" WHERE name = "Force"');
        $this->addSql('UPDATE characteristic SET label = name WHERE name = "Hâte"');
        $this->addSql('UPDATE characteristic SET name = "haste" WHERE name = "Hâte"');
        $this->addSql('UPDATE characteristic SET label = name WHERE name = "Intelligence"');
        $this->addSql('UPDATE characteristic SET name = "intelligence" WHERE name = "Intelligence"');
        $this->addSql('UPDATE characteristic SET label = name WHERE name = "Confiance"');
        $this->addSql('UPDATE characteristic SET name = "focus" WHERE name = "Confiance"');
        $this->addSql('DELETE FROM characteristic WHERE name = "Mana"');
        $this->addSql('DELETE FROM characteristic WHERE name = "Résistance physique"');
        $this->addSql('DELETE FROM characteristic WHERE name = "Résistance magique"');


    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE characteristic DROP label');
        $this->addSql('UPDATE characteristic SET name = "Vie" WHERE name = "health"');
        $this->addSql('UPDATE characteristic SET name = "Hâte" WHERE name = "haste"');
        $this->addSql('UPDATE characteristic SET name = "Intelligence" WHERE name = "intelligence"');
        $this->addSql('UPDATE characteristic SET name = "Confiance" WHERE name = "focus"');

    }
}
