<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190218141259 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE lessee ADD user_lessee_id INT DEFAULT NULL, ADD full_name VARCHAR(510) NOT NULL');
        $this->addSql('ALTER TABLE lessee ADD CONSTRAINT FK_954945F150A913D2 FOREIGN KEY (user_lessee_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_954945F150A913D2 ON lessee (user_lessee_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE lessee DROP FOREIGN KEY FK_954945F150A913D2');
        $this->addSql('DROP INDEX IDX_954945F150A913D2 ON lessee');
        $this->addSql('ALTER TABLE lessee DROP user_lessee_id, DROP full_name');
    }
}
