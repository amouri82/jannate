<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200429023248 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE salary_package (id INT AUTO_INCREMENT NOT NULL, salary VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE teacher (id INT AUTO_INCREMENT NOT NULL, salary_package_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, father_name VARCHAR(255) DEFAULT NULL, cnic VARCHAR(30) DEFAULT NULL, address LONGTEXT DEFAULT NULL, email VARCHAR(255) NOT NULL, mobile VARCHAR(20) DEFAULT NULL, telephone VARCHAR(20) DEFAULT NULL, birthday DATE DEFAULT NULL, nationality VARCHAR(30) DEFAULT NULL, skype VARCHAR(30) DEFAULT NULL, username VARCHAR(100) NOT NULL, password VARCHAR(100) NOT NULL, qualification1 VARCHAR(255) DEFAULT NULL, qualification2 VARCHAR(255) DEFAULT NULL, qualification3 VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, INDEX IDX_B0F6A6D5E03A62C5 (salary_package_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE teacher ADD CONSTRAINT FK_B0F6A6D5E03A62C5 FOREIGN KEY (salary_package_id) REFERENCES salary_package (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE teacher DROP FOREIGN KEY FK_B0F6A6D5E03A62C5');
        $this->addSql('DROP TABLE salary_package');
        $this->addSql('DROP TABLE teacher');
    }
}
