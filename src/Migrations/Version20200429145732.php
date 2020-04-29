<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200429145732 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE department (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, department VARCHAR(100) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, position INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE student ADD teacher_id INT NOT NULL, ADD department_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE student ADD CONSTRAINT FK_B723AF3341807E1D FOREIGN KEY (teacher_id) REFERENCES employee (id)');
        $this->addSql('ALTER TABLE student ADD CONSTRAINT FK_B723AF33AE80F5DF FOREIGN KEY (department_id) REFERENCES department (id)');
        $this->addSql('CREATE INDEX IDX_B723AF3341807E1D ON student (teacher_id)');
        $this->addSql('CREATE INDEX IDX_B723AF33AE80F5DF ON student (department_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE student DROP FOREIGN KEY FK_B723AF33AE80F5DF');
        $this->addSql('DROP TABLE department');
        $this->addSql('ALTER TABLE student DROP FOREIGN KEY FK_B723AF3341807E1D');
        $this->addSql('DROP INDEX IDX_B723AF3341807E1D ON student');
        $this->addSql('DROP INDEX IDX_B723AF33AE80F5DF ON student');
        $this->addSql('ALTER TABLE student DROP teacher_id, DROP department_id');
    }
}
