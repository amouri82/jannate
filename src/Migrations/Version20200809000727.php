<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200809000727 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE request ADD student_name1 VARCHAR(100) DEFAULT NULL, ADD student_gender1 VARCHAR(10) DEFAULT NULL, ADD student_age1 INT DEFAULT NULL, ADD student_name2 VARCHAR(100) DEFAULT NULL, ADD student_gender2 VARCHAR(10) DEFAULT NULL, ADD student_age2 INT DEFAULT NULL, ADD student_name3 VARCHAR(100) DEFAULT NULL, ADD student_gender3 VARCHAR(10) DEFAULT NULL, ADD student_age3 INT DEFAULT NULL, ADD student_name4 VARCHAR(100) DEFAULT NULL, ADD student_gender4 VARCHAR(10) NOT NULL, ADD student_age4 INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE request DROP student_name1, DROP student_gender1, DROP student_age1, DROP student_name2, DROP student_gender2, DROP student_age2, DROP student_name3, DROP student_gender3, DROP student_age3, DROP student_name4, DROP student_gender4, DROP student_age4');
    }
}
