<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190212151125 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE equipment ADD name VARCHAR(255) DEFAULT NULL, DROP elevator, DROP cellar, DROP garden, DROP parking, DROP balcony, DROP optical_fiber, DROP intercom, DROP terrace, DROP swimming_pool');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE equipment ADD elevator TINYINT(1) DEFAULT NULL, ADD cellar TINYINT(1) DEFAULT NULL, ADD garden TINYINT(1) DEFAULT NULL, ADD parking TINYINT(1) DEFAULT NULL, ADD balcony TINYINT(1) DEFAULT NULL, ADD optical_fiber TINYINT(1) DEFAULT NULL, ADD intercom TINYINT(1) DEFAULT NULL, ADD terrace TINYINT(1) DEFAULT NULL, ADD swimming_pool TINYINT(1) DEFAULT NULL, DROP name');
    }
}
