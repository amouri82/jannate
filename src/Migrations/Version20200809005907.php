<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200809005907 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE request ADD parent_id INT DEFAULT NULL, ADD no_c VARCHAR(30) DEFAULT NULL, ADD news VARCHAR(30) DEFAULT NULL');
        $this->addSql('ALTER TABLE request ADD CONSTRAINT FK_3B978F9F727ACA70 FOREIGN KEY (parent_id) REFERENCES family (id)');
        $this->addSql('CREATE INDEX IDX_3B978F9F727ACA70 ON request (parent_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE request DROP FOREIGN KEY FK_3B978F9F727ACA70');
        $this->addSql('DROP INDEX IDX_3B978F9F727ACA70 ON request');
        $this->addSql('ALTER TABLE request DROP parent_id, DROP no_c, DROP news');
    }
}
