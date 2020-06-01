<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200601002427 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE family ADD timezone_id INT DEFAULT NULL, ADD country_id INT DEFAULT NULL, ADD currency_id INT DEFAULT NULL, ADD payment_mode VARCHAR(30) DEFAULT NULL, ADD zoom VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE family ADD CONSTRAINT FK_A5E6215B3FE997DE FOREIGN KEY (timezone_id) REFERENCES timezone (id)');
        $this->addSql('ALTER TABLE family ADD CONSTRAINT FK_A5E6215BF92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE family ADD CONSTRAINT FK_A5E6215B38248176 FOREIGN KEY (currency_id) REFERENCES currency (id)');
        $this->addSql('CREATE INDEX IDX_A5E6215B3FE997DE ON family (timezone_id)');
        $this->addSql('CREATE INDEX IDX_A5E6215BF92F3E70 ON family (country_id)');
        $this->addSql('CREATE INDEX IDX_A5E6215B38248176 ON family (currency_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE family DROP FOREIGN KEY FK_A5E6215B3FE997DE');
        $this->addSql('ALTER TABLE family DROP FOREIGN KEY FK_A5E6215BF92F3E70');
        $this->addSql('ALTER TABLE family DROP FOREIGN KEY FK_A5E6215B38248176');
        $this->addSql('DROP INDEX IDX_A5E6215B3FE997DE ON family');
        $this->addSql('DROP INDEX IDX_A5E6215BF92F3E70 ON family');
        $this->addSql('DROP INDEX IDX_A5E6215B38248176 ON family');
        $this->addSql('ALTER TABLE family DROP timezone_id, DROP country_id, DROP currency_id, DROP payment_mode, DROP zoom');
    }
}
