<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Class Version20190329093903
 * @package DoctrineMigrations
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190329093903 extends AbstractMigration
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

        $this->addSql('ALTER TABLE rent_release DROP FOREIGN KEY FK_7F6B786D1BC8D612');
        $this->addSql('ALTER TABLE rent_release CHANGE rent_release_id rent_release_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE rent_release ADD CONSTRAINT FK_7F6B786D1BC8D612 FOREIGN KEY (rent_release_id) REFERENCES lessee (id) ON DELETE SET NULL');
    }

    /**
     * @param Schema $schema
     * @throws \Doctrine\DBAL\DBALException
     */
    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE rent_release DROP FOREIGN KEY FK_7F6B786D1BC8D612');
        $this->addSql('ALTER TABLE rent_release CHANGE rent_release_id rent_release_id INT NOT NULL');
        $this->addSql('ALTER TABLE rent_release ADD CONSTRAINT FK_7F6B786D1BC8D612 FOREIGN KEY (rent_release_id) REFERENCES lessee (id)');
    }
}
