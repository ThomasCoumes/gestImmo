<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190212132806 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE equipment (id INT AUTO_INCREMENT NOT NULL, equipment_id INT DEFAULT NULL, elevator TINYINT(1) DEFAULT NULL, cellar TINYINT(1) DEFAULT NULL, garden TINYINT(1) DEFAULT NULL, parking TINYINT(1) DEFAULT NULL, balcony TINYINT(1) DEFAULT NULL, optical_fiber TINYINT(1) DEFAULT NULL, intercom TINYINT(1) DEFAULT NULL, terrace TINYINT(1) DEFAULT NULL, swimming_pool TINYINT(1) DEFAULT NULL, INDEX IDX_D338D583517FE9FE (equipment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE equipment ADD CONSTRAINT FK_D338D583517FE9FE FOREIGN KEY (equipment_id) REFERENCES property (id)');
        $this->addSql('ALTER TABLE property DROP equipment');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE equipment');
        $this->addSql('ALTER TABLE property ADD equipment LONGTEXT DEFAULT NULL COLLATE utf8mb4_unicode_ci COMMENT \'(DC2Type:object)\'');
    }
}
