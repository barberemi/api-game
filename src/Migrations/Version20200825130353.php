<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200825130353 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE bind_characteristic DROP FOREIGN KEY FK_5CCC1CBF6D55ACAB');
        $this->addSql('DROP INDEX IDX_5CCC1CBF6D55ACAB ON bind_characteristic');
        $this->addSql('ALTER TABLE bind_characteristic CHANGE academy_id base_academy_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE bind_characteristic ADD CONSTRAINT FK_5CCC1CBFFEEF7FA7 FOREIGN KEY (base_academy_id) REFERENCES academy (id)');
        $this->addSql('CREATE INDEX IDX_5CCC1CBFFEEF7FA7 ON bind_characteristic (base_academy_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE bind_characteristic DROP FOREIGN KEY FK_5CCC1CBFFEEF7FA7');
        $this->addSql('DROP INDEX IDX_5CCC1CBFFEEF7FA7 ON bind_characteristic');
        $this->addSql('ALTER TABLE bind_characteristic CHANGE base_academy_id academy_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE bind_characteristic ADD CONSTRAINT FK_5CCC1CBF6D55ACAB FOREIGN KEY (academy_id) REFERENCES academy (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_5CCC1CBF6D55ACAB ON bind_characteristic (academy_id)');
    }
}
