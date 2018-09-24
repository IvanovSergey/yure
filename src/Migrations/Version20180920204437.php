<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180920204437 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE statements ADD category_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE statements ADD CONSTRAINT FK_A2A8C0539777D11E FOREIGN KEY (category_id_id) REFERENCES categories (id)');
        $this->addSql('CREATE INDEX IDX_A2A8C0539777D11E ON statements (category_id_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE statements DROP FOREIGN KEY FK_A2A8C0539777D11E');
        $this->addSql('DROP INDEX IDX_A2A8C0539777D11E ON statements');
        $this->addSql('ALTER TABLE statements DROP category_id_id');
    }
}
