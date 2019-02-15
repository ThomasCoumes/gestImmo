<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190215115038 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE property DROP FOREIGN KEY FK_8BF21CDEBF396750');
        $this->addSql('ALTER TABLE property ADD user_property_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT FK_8BF21CDEFD89DA79 FOREIGN KEY (user_property_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_8BF21CDEFD89DA79 ON property (user_property_id)');
        $this->addSql('ALTER TABLE equipment DROP FOREIGN KEY FK_D338D583517FE9FE');
        $this->addSql('ALTER TABLE equipment ADD property_who_get_it LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE equipment ADD CONSTRAINT FK_D338D583517FE9FE FOREIGN KEY (equipment_id) REFERENCES property (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE equipment DROP FOREIGN KEY FK_D338D583517FE9FE');
        $this->addSql('ALTER TABLE equipment DROP property_who_get_it');
        $this->addSql('ALTER TABLE equipment ADD CONSTRAINT FK_D338D583517FE9FE FOREIGN KEY (equipment_id) REFERENCES property (id)');
        $this->addSql('ALTER TABLE property DROP FOREIGN KEY FK_8BF21CDEFD89DA79');
        $this->addSql('DROP INDEX IDX_8BF21CDEFD89DA79 ON property');
        $this->addSql('ALTER TABLE property DROP user_property_id');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT FK_8BF21CDEBF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
    }
}
