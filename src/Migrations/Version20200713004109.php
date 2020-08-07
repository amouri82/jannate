<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200713004109 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE lesson_image (id INT AUTO_INCREMENT NOT NULL, lesson_id INT DEFAULT NULL, image VARCHAR(100) NOT NULL, position INT NOT NULL, page_name VARCHAR(100) NOT NULL, INDEX IDX_8FDBD0D8CDF80196 (lesson_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE monitor (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE lesson_image ADD CONSTRAINT FK_8FDBD0D8CDF80196 FOREIGN KEY (lesson_id) REFERENCES lesson (id)');
        $this->addSql('DROP TABLE lesson_category');
        $this->addSql('DROP TABLE lesson_level');
        $this->addSql('ALTER TABLE employee ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE employee ADD CONSTRAINT FK_5D9F75A1A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_5D9F75A1A76ED395 ON employee (user_id)');
        $this->addSql('ALTER TABLE family ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE family ADD CONSTRAINT FK_A5E6215BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_A5E6215BA76ED395 ON family (user_id)');
        $this->addSql('ALTER TABLE head ADD CONSTRAINT FK_A7F3F69CD3EA1365 FOREIGN KEY (headcategory_id) REFERENCES head_category (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE lesson_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE lesson_level (id INT AUTO_INCREMENT NOT NULL, level VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE lesson_image');
        $this->addSql('DROP TABLE monitor');
        $this->addSql('ALTER TABLE employee DROP FOREIGN KEY FK_5D9F75A1A76ED395');
        $this->addSql('DROP INDEX IDX_5D9F75A1A76ED395 ON employee');
        $this->addSql('ALTER TABLE employee DROP user_id');
        $this->addSql('ALTER TABLE family DROP FOREIGN KEY FK_A5E6215BA76ED395');
        $this->addSql('DROP INDEX IDX_A5E6215BA76ED395 ON family');
        $this->addSql('ALTER TABLE family DROP user_id');
        $this->addSql('ALTER TABLE head DROP FOREIGN KEY FK_A7F3F69CD3EA1365');
    }
}
