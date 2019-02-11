<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190211155026 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE equipment (id INT AUTO_INCREMENT NOT NULL, elevator TINYINT(1) DEFAULT NULL, cellar TINYINT(1) DEFAULT NULL, garden TINYINT(1) DEFAULT NULL, parking TINYINT(1) DEFAULT NULL, balcony TINYINT(1) DEFAULT NULL, optical_fiber TINYINT(1) DEFAULT NULL, intercom TINYINT(1) DEFAULT NULL, terrace TINYINT(1) DEFAULT NULL, swimming_pool TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE property (id INT AUTO_INCREMENT NOT NULL, property_type_id INT NOT NULL, unique_name_id INT NOT NULL, address_id INT NOT NULL, city_id INT NOT NULL, zip_code_id INT NOT NULL, country_id INT DEFAULT NULL, surface_in_squar_meter_id INT NOT NULL, number_of_piece_id INT NOT NULL, description_id INT DEFAULT NULL, equipment_id INT DEFAULT NULL, rental_type_id INT NOT NULL, rent_excluding_charge_id INT NOT NULL, charges_id INT NOT NULL, purchase_price_id INT NOT NULL, INDEX IDX_8BF21CDE9C81C6EB (property_type_id), INDEX IDX_8BF21CDEA7DC815E (unique_name_id), INDEX IDX_8BF21CDEF5B7AF75 (address_id), INDEX IDX_8BF21CDE8BAC62AF (city_id), INDEX IDX_8BF21CDE9CEB97F7 (zip_code_id), INDEX IDX_8BF21CDEF92F3E70 (country_id), INDEX IDX_8BF21CDE9A86544 (surface_in_squar_meter_id), INDEX IDX_8BF21CDE5C7E699E (number_of_piece_id), INDEX IDX_8BF21CDED9F966B (description_id), INDEX IDX_8BF21CDE517FE9FE (equipment_id), INDEX IDX_8BF21CDE16AA567C (rental_type_id), INDEX IDX_8BF21CDE4309CAC (rent_excluding_charge_id), INDEX IDX_8BF21CDEFDFE4111 (charges_id), INDEX IDX_8BF21CDEFFD6D4B5 (purchase_price_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT FK_8BF21CDE9C81C6EB FOREIGN KEY (property_type_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT FK_8BF21CDEA7DC815E FOREIGN KEY (unique_name_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT FK_8BF21CDEF5B7AF75 FOREIGN KEY (address_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT FK_8BF21CDE8BAC62AF FOREIGN KEY (city_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT FK_8BF21CDE9CEB97F7 FOREIGN KEY (zip_code_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT FK_8BF21CDEF92F3E70 FOREIGN KEY (country_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT FK_8BF21CDE9A86544 FOREIGN KEY (surface_in_squar_meter_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT FK_8BF21CDE5C7E699E FOREIGN KEY (number_of_piece_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT FK_8BF21CDED9F966B FOREIGN KEY (description_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT FK_8BF21CDE517FE9FE FOREIGN KEY (equipment_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT FK_8BF21CDE16AA567C FOREIGN KEY (rental_type_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT FK_8BF21CDE4309CAC FOREIGN KEY (rent_excluding_charge_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT FK_8BF21CDEFDFE4111 FOREIGN KEY (charges_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT FK_8BF21CDEFFD6D4B5 FOREIGN KEY (purchase_price_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE property DROP FOREIGN KEY FK_8BF21CDE9C81C6EB');
        $this->addSql('ALTER TABLE property DROP FOREIGN KEY FK_8BF21CDEA7DC815E');
        $this->addSql('ALTER TABLE property DROP FOREIGN KEY FK_8BF21CDEF5B7AF75');
        $this->addSql('ALTER TABLE property DROP FOREIGN KEY FK_8BF21CDE8BAC62AF');
        $this->addSql('ALTER TABLE property DROP FOREIGN KEY FK_8BF21CDE9CEB97F7');
        $this->addSql('ALTER TABLE property DROP FOREIGN KEY FK_8BF21CDEF92F3E70');
        $this->addSql('ALTER TABLE property DROP FOREIGN KEY FK_8BF21CDE9A86544');
        $this->addSql('ALTER TABLE property DROP FOREIGN KEY FK_8BF21CDE5C7E699E');
        $this->addSql('ALTER TABLE property DROP FOREIGN KEY FK_8BF21CDED9F966B');
        $this->addSql('ALTER TABLE property DROP FOREIGN KEY FK_8BF21CDE517FE9FE');
        $this->addSql('ALTER TABLE property DROP FOREIGN KEY FK_8BF21CDE16AA567C');
        $this->addSql('ALTER TABLE property DROP FOREIGN KEY FK_8BF21CDE4309CAC');
        $this->addSql('ALTER TABLE property DROP FOREIGN KEY FK_8BF21CDEFDFE4111');
        $this->addSql('ALTER TABLE property DROP FOREIGN KEY FK_8BF21CDEFFD6D4B5');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE equipment');
        $this->addSql('DROP TABLE property');
    }
}
