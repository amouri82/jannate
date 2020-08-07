<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200713012521 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE employee DROP INDEX IDX_5D9F75A1A76ED395, ADD UNIQUE INDEX UNIQ_5D9F75A1A76ED395 (user_id)');
        $this->addSql('ALTER TABLE family DROP INDEX IDX_A5E6215BA76ED395, ADD UNIQUE INDEX UNIQ_A5E6215BA76ED395 (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE employee DROP INDEX UNIQ_5D9F75A1A76ED395, ADD INDEX IDX_5D9F75A1A76ED395 (user_id)');
        $this->addSql('ALTER TABLE family DROP INDEX UNIQ_A5E6215BA76ED395, ADD INDEX IDX_A5E6215BA76ED395 (user_id)');
    }
}
