<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200501235124 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE student DROP FOREIGN KEY FK_B723AF33AE80F5DF');
        $this->addSql('ALTER TABLE department DROP FOREIGN KEY FK_CD1DE18AE39F76E9');
        $this->addSql('ALTER TABLE department DROP FOREIGN KEY FK_CD1DE18A17F601BE');
        $this->addSql('CREATE TABLE course (id INT AUTO_INCREMENT NOT NULL, course_level_id INT NOT NULL, course_category_id INT NOT NULL, name VARCHAR(100) NOT NULL, display_name VARCHAR(100) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, position INT NOT NULL, age INT DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_169E6FB9F60526F1 (course_level_id), INDEX IDX_169E6FB96628AD36 (course_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE course_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE course_level (id INT AUTO_INCREMENT NOT NULL, level VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE course ADD CONSTRAINT FK_169E6FB9F60526F1 FOREIGN KEY (course_level_id) REFERENCES course_level (id)');
        $this->addSql('ALTER TABLE course ADD CONSTRAINT FK_169E6FB96628AD36 FOREIGN KEY (course_category_id) REFERENCES course_category (id)');
        $this->addSql('DROP TABLE department');
        $this->addSql('DROP TABLE lesson_category');
        $this->addSql('DROP TABLE lesson_level');
        $this->addSql('DROP INDEX IDX_B723AF33AE80F5DF ON student');
        $this->addSql('ALTER TABLE student DROP department_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE course DROP FOREIGN KEY FK_169E6FB96628AD36');
        $this->addSql('ALTER TABLE course DROP FOREIGN KEY FK_169E6FB9F60526F1');
        $this->addSql('CREATE TABLE department (id INT AUTO_INCREMENT NOT NULL, lesson_level_id INT NOT NULL, lesson_category_id INT NOT NULL, name VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, department VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, position INT NOT NULL, age INT DEFAULT NULL, image VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_CD1DE18AE39F76E9 (lesson_category_id), INDEX IDX_CD1DE18A17F601BE (lesson_level_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE lesson_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE lesson_level (id INT AUTO_INCREMENT NOT NULL, level VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE department ADD CONSTRAINT FK_CD1DE18A17F601BE FOREIGN KEY (lesson_level_id) REFERENCES lesson_level (id)');
        $this->addSql('ALTER TABLE department ADD CONSTRAINT FK_CD1DE18AE39F76E9 FOREIGN KEY (lesson_category_id) REFERENCES lesson_category (id)');
        $this->addSql('DROP TABLE course');
        $this->addSql('DROP TABLE course_category');
        $this->addSql('DROP TABLE course_level');
        $this->addSql('ALTER TABLE student ADD department_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE student ADD CONSTRAINT FK_B723AF33AE80F5DF FOREIGN KEY (department_id) REFERENCES department (id)');
        $this->addSql('CREATE INDEX IDX_B723AF33AE80F5DF ON student (department_id)');
    }
}
