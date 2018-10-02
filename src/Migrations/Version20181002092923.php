<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181002092923 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE statement_request ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE statement_request ADD CONSTRAINT FK_31AE10C1A76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id)');
        $this->addSql('CREATE INDEX IDX_31AE10C1A76ED395 ON statement_request (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE statement_request DROP FOREIGN KEY FK_31AE10C1A76ED395');
        $this->addSql('DROP INDEX IDX_31AE10C1A76ED395 ON statement_request');
        $this->addSql('ALTER TABLE statement_request DROP user_id');
    }
}
