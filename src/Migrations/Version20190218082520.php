<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190218082520 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE equipment_property (equipment_id INT NOT NULL, property_id INT NOT NULL, INDEX IDX_BB3198F8517FE9FE (equipment_id), INDEX IDX_BB3198F8549213EC (property_id), PRIMARY KEY(equipment_id, property_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE equipment_property ADD CONSTRAINT FK_BB3198F8517FE9FE FOREIGN KEY (equipment_id) REFERENCES equipment (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE equipment_property ADD CONSTRAINT FK_BB3198F8549213EC FOREIGN KEY (property_id) REFERENCES property (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE equipment DROP FOREIGN KEY FK_D338D583517FE9FE');
        $this->addSql('DROP INDEX IDX_D338D583517FE9FE ON equipment');
        $this->addSql('ALTER TABLE equipment DROP equipment_id, DROP property_who_get_it, CHANGE name name VARCHAR(255) NOT NULL');
        $this->addSql('INSERT INTO equipment (name) VALUE (\'Ascenseur\');');
        $this->addSql('INSERT INTO equipment (name) VALUE (\'Cave\');');
        $this->addSql('INSERT INTO equipment (name) VALUE (\'Jardin\');');
        $this->addSql('INSERT INTO equipment (name) VALUE (\'Parking\');');
        $this->addSql('INSERT INTO equipment (name) VALUE (\'Balcon\');');
        $this->addSql('INSERT INTO equipment (name) VALUE (\'Fibre optique\');');
        $this->addSql('INSERT INTO equipment (name) VALUE (\'Interphone\');');
        $this->addSql('INSERT INTO equipment (name) VALUE (\'Terrasse\');');
        $this->addSql('INSERT INTO equipment (name) VALUE (\'Piscine\');');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE equipment_property');
        $this->addSql('ALTER TABLE equipment ADD equipment_id INT DEFAULT NULL, ADD property_who_get_it LONGTEXT DEFAULT NULL COLLATE utf8mb4_unicode_ci COMMENT \'(DC2Type:array)\', CHANGE name name VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE equipment ADD CONSTRAINT FK_D338D583517FE9FE FOREIGN KEY (equipment_id) REFERENCES property (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_D338D583517FE9FE ON equipment (equipment_id)');
    }
}
