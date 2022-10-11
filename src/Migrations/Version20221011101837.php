<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221011101837 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE guild ALTER season_day SET DEFAULT 1');
        $this->addSql('UPDATE guild SET season_day = 1 WHERE season_day = 0');

        $this->addSql('ALTER TABLE guild ALTER season_record SET DEFAULT 1');
        $this->addSql('UPDATE guild SET season_record = 1 WHERE season_record = 0');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
