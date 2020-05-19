<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200519021234 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE employee ADD bank VARCHAR(100) DEFAULT NULL, ADD branch VARCHAR(100) DEFAULT NULL, ADD currency VARCHAR(10) DEFAULT NULL, ADD medical VARCHAR(255) DEFAULT NULL, ADD entertainment VARCHAR(255) DEFAULT NULL, ADD misc VARCHAR(255) DEFAULT NULL, ADD account_title VARCHAR(100) DEFAULT NULL, ADD account_no VARCHAR(255) DEFAULT NULL, ADD salary_amount NUMERIC(10, 2) DEFAULT NULL, ADD eobi VARCHAR(60) DEFAULT NULL, ADD whatsup_group VARCHAR(255) DEFAULT NULL, ADD hour_rate VARCHAR(60) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE employee DROP bank, DROP branch, DROP currency, DROP medical, DROP entertainment, DROP misc, DROP account_title, DROP account_no, DROP salary_amount, DROP eobi, DROP whatsup_group, DROP hour_rate');
    }
}
