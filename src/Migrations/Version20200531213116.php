<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200531213116 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE student DROP FOREIGN KEY FK_B723AF33727ACA70');
        $this->addSql('CREATE TABLE family (id INT AUTO_INCREMENT NOT NULL, status_id INT DEFAULT NULL, invoice_type_id INT DEFAULT NULL, name VARCHAR(100) NOT NULL, email VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, telephone VARCHAR(20) DEFAULT NULL, mobile VARCHAR(20) DEFAULT NULL, skype VARCHAR(30) DEFAULT NULL, fee VARCHAR(20) DEFAULT NULL, active INT DEFAULT NULL, city VARCHAR(30) DEFAULT NULL, trial_date DATETIME DEFAULT NULL, regular_date DATETIME DEFAULT NULL, leave_date DATETIME DEFAULT NULL, deactivation_date DATETIME DEFAULT NULL, suspension_date DATETIME DEFAULT NULL, bank VARCHAR(100) DEFAULT NULL, student_bank VARCHAR(100) DEFAULT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, INDEX IDX_A5E6215B6BF700BD (status_id), INDEX IDX_A5E6215B3795BA40 (invoice_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE family ADD CONSTRAINT FK_A5E6215B6BF700BD FOREIGN KEY (status_id) REFERENCES status (id)');
        $this->addSql('ALTER TABLE family ADD CONSTRAINT FK_A5E6215B3795BA40 FOREIGN KEY (invoice_type_id) REFERENCES invoice_type (id)');
        $this->addSql('DROP TABLE parent_account');
        $this->addSql('DROP INDEX IDX_B723AF33727ACA70 ON student');
        $this->addSql('ALTER TABLE student CHANGE parent_id family_id INT NOT NULL');
        $this->addSql('ALTER TABLE student ADD CONSTRAINT FK_B723AF33C35E566A FOREIGN KEY (family_id) REFERENCES family (id)');
        $this->addSql('CREATE INDEX IDX_B723AF33C35E566A ON student (family_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE student DROP FOREIGN KEY FK_B723AF33C35E566A');
        $this->addSql('CREATE TABLE parent_account (id INT AUTO_INCREMENT NOT NULL, status_id INT DEFAULT NULL, invoice_type_id INT DEFAULT NULL, name VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, email VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, username VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, password VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, telephone VARCHAR(20) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, mobile VARCHAR(20) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, skype VARCHAR(30) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, fee VARCHAR(20) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, active INT DEFAULT NULL, city VARCHAR(30) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, trial_date DATETIME DEFAULT NULL, regular_date DATETIME DEFAULT NULL, leave_date DATETIME DEFAULT NULL, deactivation_date DATETIME DEFAULT NULL, suspension_date DATETIME DEFAULT NULL, bank VARCHAR(100) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, student_bank VARCHAR(100) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, INDEX IDX_F7E22E23795BA40 (invoice_type_id), INDEX IDX_F7E22E26BF700BD (status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE parent_account ADD CONSTRAINT FK_F7E22E23795BA40 FOREIGN KEY (invoice_type_id) REFERENCES invoice_type (id)');
        $this->addSql('ALTER TABLE parent_account ADD CONSTRAINT FK_F7E22E26BF700BD FOREIGN KEY (status_id) REFERENCES status (id)');
        $this->addSql('DROP TABLE family');
        $this->addSql('DROP INDEX IDX_B723AF33C35E566A ON student');
        $this->addSql('ALTER TABLE student CHANGE family_id parent_id INT NOT NULL');
        $this->addSql('ALTER TABLE student ADD CONSTRAINT FK_B723AF33727ACA70 FOREIGN KEY (parent_id) REFERENCES parent_account (id)');
        $this->addSql('CREATE INDEX IDX_B723AF33727ACA70 ON student (parent_id)');
    }
}
