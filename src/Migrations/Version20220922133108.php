<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220922133108 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // UPDATE id of academies to correspond between dev & prod
        $this->addSql('UPDATE academy SET id = 7 WHERE name = "warrior"');
        $this->addSql('UPDATE academy SET id = 8 WHERE name = "hunter"');
        $this->addSql('UPDATE academy SET id = 10 WHERE name = "magician"');

        // UPDATE id of characteristics to correspond between dev & prod
        $this->addSql('UPDATE characteristic SET id = 2 WHERE name = "health"');
        $this->addSql('UPDATE characteristic SET id = 7 WHERE name = "intelligence"');
        $this->addSql('UPDATE characteristic SET id = 8 WHERE name = "strength"');
        $this->addSql('UPDATE characteristic SET id = 9 WHERE name = "agility"');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
