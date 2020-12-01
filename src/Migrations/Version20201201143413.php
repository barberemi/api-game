<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201201143413 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX user_id ON bind_characteristic');
        $this->addSql('ALTER TABLE bind_characteristic CHANGE user_id academy_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE bind_characteristic ADD CONSTRAINT FK_5CCC1CBF6D55ACAB FOREIGN KEY (academy_id) REFERENCES academy (id)');
        $this->addSql('CREATE INDEX IDX_5CCC1CBF6D55ACAB ON bind_characteristic (academy_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE bind_characteristic DROP FOREIGN KEY FK_5CCC1CBF6D55ACAB');
        $this->addSql('DROP INDEX IDX_5CCC1CBF6D55ACAB ON bind_characteristic');
        $this->addSql('ALTER TABLE bind_characteristic CHANGE academy_id user_id INT DEFAULT NULL');
        $this->addSql('CREATE INDEX user_id ON bind_characteristic (user_id)');
    }
}
