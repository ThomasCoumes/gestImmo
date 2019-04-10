<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Class Version20190222085448
 * @package DoctrineMigrations
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190222085448 extends AbstractMigration
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

        $this->addSql('ALTER TABLE property ADD pdf_file VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE lost_user ADD email VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE lessee ADD invitation_token VARCHAR(255) DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     * @throws \Doctrine\DBAL\DBALException
     */
    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE lost_user DROP email');
        $this->addSql('ALTER TABLE property DROP pdf_file');
        $this->addSql('ALTER TABLE lessee DROP invitation_token');
    }
}
