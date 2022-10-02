<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221002173907 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('UPDATE bind_characteristic SET amount = 0 WHERE base_academy_id IS NOT NULL');
        $this->addSql('DELETE IGNORE FROM bind_characteristic WHERE characteristic_id = 9 AND base_academy_id IS NOT NULL');
        $this->addSql('DELETE IGNORE FROM bind_characteristic WHERE characteristic_id = 9 AND academy_id IS NOT NULL');
        $this->addSql('UPDATE bind_characteristic SET characteristic_id = 8 WHERE characteristic_id = 9');
        $this->addSql('DELETE IGNORE FROM characteristic WHERE id = 9');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
