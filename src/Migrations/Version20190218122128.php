<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Class Version20190218122128
 * @package DoctrineMigrations
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190218122128 extends AbstractMigration
{
    /**
     * @return string
     */
    public function getDescription() : string
    {
        return '';
    }

    /**
     * @param Schema $schema
     * @throws \Doctrine\DBAL\DBALException
     */
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE lessee_property (lessee_id INT NOT NULL, property_id INT NOT NULL, INDEX IDX_D9FAF5B450499E36 (lessee_id), INDEX IDX_D9FAF5B4549213EC (property_id), PRIMARY KEY(lessee_id, property_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE lessee_property ADD CONSTRAINT FK_D9FAF5B450499E36 FOREIGN KEY (lessee_id) REFERENCES lessee (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lessee_property ADD CONSTRAINT FK_D9FAF5B4549213EC FOREIGN KEY (property_id) REFERENCES property (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lessee ADD full_name VARCHAR(511) NOT NULL');
    }

    /**
     * @param Schema $schema
     * @throws \Doctrine\DBAL\DBALException
     */
    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE lessee_property');
    }
}
