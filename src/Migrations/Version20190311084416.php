<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Class Version20190311084416
 * @package DoctrineMigrations
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190311084416 extends AbstractMigration
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

        $this->addSql('ALTER TABLE rent_release ADD user_rent_release_id INT NOT NULL');
        $this->addSql('ALTER TABLE rent_release ADD CONSTRAINT FK_7F6B786D914BA9D FOREIGN KEY (user_rent_release_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_7F6B786D914BA9D ON rent_release (user_rent_release_id)');
        $this->addSql('ALTER TABLE rent_release ADD pdf LONGTEXT DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     * @throws \Doctrine\DBAL\DBALException
     */
    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE rent_release DROP FOREIGN KEY FK_7F6B786D914BA9D');
        $this->addSql('DROP INDEX IDX_7F6B786D914BA9D ON rent_release');
        $this->addSql('ALTER TABLE rent_release DROP user_rent_release_id');
        $this->addSql('ALTER TABLE rent_release DROP pdf');
    }
}
