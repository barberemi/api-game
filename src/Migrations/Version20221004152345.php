<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221004152345 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('INSERT IGNORE INTO season (id, is_rewarded, starting_at, ending_at, created_at, updated_at) VALUES (1, 0, "2022-07-01", "2022-12-31", "' . date_create()->format('Y-m-d H:i:s') . '", "' . date_create()->format('Y-m-d H:i:s') . '")');
        $this->addSql('INSERT IGNORE INTO season (id, is_rewarded, starting_at, ending_at, created_at, updated_at) VALUES (2, 0, "2023-01-01", "2023-06-30", "' . date_create()->format('Y-m-d H:i:s') . '", "' . date_create()->format('Y-m-d H:i:s') . '")');
        $this->addSql('INSERT IGNORE INTO season (id, is_rewarded, starting_at, ending_at, created_at, updated_at) VALUES (3, 0, "2023-07-01", "2023-12-31", "' . date_create()->format('Y-m-d H:i:s') . '", "' . date_create()->format('Y-m-d H:i:s') . '")');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
