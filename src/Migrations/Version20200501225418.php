<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200501225418 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE department ADD lesson_level_id INT NOT NULL, ADD lesson_category_id INT NOT NULL');
        $this->addSql('ALTER TABLE department ADD CONSTRAINT FK_CD1DE18A17F601BE FOREIGN KEY (lesson_level_id) REFERENCES lesson_level (id)');
        $this->addSql('ALTER TABLE department ADD CONSTRAINT FK_CD1DE18AE39F76E9 FOREIGN KEY (lesson_category_id) REFERENCES lesson_category (id)');
        $this->addSql('CREATE INDEX IDX_CD1DE18A17F601BE ON department (lesson_level_id)');
        $this->addSql('CREATE INDEX IDX_CD1DE18AE39F76E9 ON department (lesson_category_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE department DROP FOREIGN KEY FK_CD1DE18A17F601BE');
        $this->addSql('ALTER TABLE department DROP FOREIGN KEY FK_CD1DE18AE39F76E9');
        $this->addSql('DROP INDEX IDX_CD1DE18A17F601BE ON department');
        $this->addSql('DROP INDEX IDX_CD1DE18AE39F76E9 ON department');
        $this->addSql('ALTER TABLE department DROP lesson_level_id, DROP lesson_category_id');
    }
}
