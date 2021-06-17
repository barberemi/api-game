<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210617082149 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('DELETE FROM characteristic WHERE name = "haste"');
        $this->addSql('UPDATE characteristic SET name = "agility", label = "Agilité", description = "Puissance physique à distance du personnage. Plus vous avez de l’agilité, plus vos compétences physique infligent des dégats." WHERE name = "focus"');
        $this->addSql('UPDATE characteristic SET description = "Puissance physique au corps à corps du personnage. Plus vous avez de la force, plus vos compétences physique infligent des dégats." WHERE name = "strength"');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
