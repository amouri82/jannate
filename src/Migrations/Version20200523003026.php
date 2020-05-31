<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200523003026 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE employee ADD start_time1_id INT DEFAULT NULL, ADD end_time1_id INT DEFAULT NULL, ADD start_time2_id INT DEFAULT NULL, ADD end_time2_id INT DEFAULT NULL, ADD start_time3_id INT DEFAULT NULL, ADD end_time3_id INT DEFAULT NULL, DROP start_time1, DROP end_time1, DROP start_time2, DROP end_time2, DROP start_time3, DROP end_time3');
        $this->addSql('ALTER TABLE employee ADD CONSTRAINT FK_5D9F75A178136858 FOREIGN KEY (start_time1_id) REFERENCES time (id)');
        $this->addSql('ALTER TABLE employee ADD CONSTRAINT FK_5D9F75A1BE7ABBE7 FOREIGN KEY (end_time1_id) REFERENCES time (id)');
        $this->addSql('ALTER TABLE employee ADD CONSTRAINT FK_5D9F75A16AA6C7B6 FOREIGN KEY (start_time2_id) REFERENCES time (id)');
        $this->addSql('ALTER TABLE employee ADD CONSTRAINT FK_5D9F75A1ACCF1409 FOREIGN KEY (end_time2_id) REFERENCES time (id)');
        $this->addSql('ALTER TABLE employee ADD CONSTRAINT FK_5D9F75A1D21AA0D3 FOREIGN KEY (start_time3_id) REFERENCES time (id)');
        $this->addSql('ALTER TABLE employee ADD CONSTRAINT FK_5D9F75A11473736C FOREIGN KEY (end_time3_id) REFERENCES time (id)');
        $this->addSql('CREATE INDEX IDX_5D9F75A178136858 ON employee (start_time1_id)');
        $this->addSql('CREATE INDEX IDX_5D9F75A1BE7ABBE7 ON employee (end_time1_id)');
        $this->addSql('CREATE INDEX IDX_5D9F75A16AA6C7B6 ON employee (start_time2_id)');
        $this->addSql('CREATE INDEX IDX_5D9F75A1ACCF1409 ON employee (end_time2_id)');
        $this->addSql('CREATE INDEX IDX_5D9F75A1D21AA0D3 ON employee (start_time3_id)');
        $this->addSql('CREATE INDEX IDX_5D9F75A11473736C ON employee (end_time3_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE employee DROP FOREIGN KEY FK_5D9F75A178136858');
        $this->addSql('ALTER TABLE employee DROP FOREIGN KEY FK_5D9F75A1BE7ABBE7');
        $this->addSql('ALTER TABLE employee DROP FOREIGN KEY FK_5D9F75A16AA6C7B6');
        $this->addSql('ALTER TABLE employee DROP FOREIGN KEY FK_5D9F75A1ACCF1409');
        $this->addSql('ALTER TABLE employee DROP FOREIGN KEY FK_5D9F75A1D21AA0D3');
        $this->addSql('ALTER TABLE employee DROP FOREIGN KEY FK_5D9F75A11473736C');
        $this->addSql('DROP INDEX IDX_5D9F75A178136858 ON employee');
        $this->addSql('DROP INDEX IDX_5D9F75A1BE7ABBE7 ON employee');
        $this->addSql('DROP INDEX IDX_5D9F75A16AA6C7B6 ON employee');
        $this->addSql('DROP INDEX IDX_5D9F75A1ACCF1409 ON employee');
        $this->addSql('DROP INDEX IDX_5D9F75A1D21AA0D3 ON employee');
        $this->addSql('DROP INDEX IDX_5D9F75A11473736C ON employee');
        $this->addSql('ALTER TABLE employee ADD start_time1 VARCHAR(10) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ADD end_time1 VARCHAR(10) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ADD start_time2 VARCHAR(10) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ADD end_time2 VARCHAR(10) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ADD start_time3 VARCHAR(10) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ADD end_time3 VARCHAR(10) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, DROP start_time1_id, DROP end_time1_id, DROP start_time2_id, DROP end_time2_id, DROP start_time3_id, DROP end_time3_id');
    }
}
