<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Class Version20190218141446
 * @package DoctrineMigrations
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190218141446 extends AbstractMigration
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

        $this->addSql('ALTER TABLE lessee ADD user_lessee_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE lessee ADD CONSTRAINT FK_954945F150A913D2 FOREIGN KEY (user_lessee_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_954945F150A913D2 ON lessee (user_lessee_id)');
        $this->addSql('CREATE TABLE lost_user (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user ADD token VARCHAR(255) DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     * @throws \Doctrine\DBAL\DBALException
     */
    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE lessee DROP FOREIGN KEY FK_954945F150A913D2');
        $this->addSql('DROP INDEX IDX_954945F150A913D2 ON lessee');
        $this->addSql('ALTER TABLE lessee DROP user_lessee_id');
        $this->addSql('DROP TABLE lost_user');
        $this->addSql('ALTER TABLE user DROP token');
    }
}
