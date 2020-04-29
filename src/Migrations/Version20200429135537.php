<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200429135537 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE parent_account ADD invoice_type_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE parent_account ADD CONSTRAINT FK_F7E22E23795BA40 FOREIGN KEY (invoice_type_id) REFERENCES invoice_type (id)');
        $this->addSql('CREATE INDEX IDX_F7E22E23795BA40 ON parent_account (invoice_type_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE parent_account DROP FOREIGN KEY FK_F7E22E23795BA40');
        $this->addSql('DROP INDEX IDX_F7E22E23795BA40 ON parent_account');
        $this->addSql('ALTER TABLE parent_account DROP invoice_type_id');
    }
}
