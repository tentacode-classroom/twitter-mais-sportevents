<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181016175000 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user ADD message_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649537A1329 FOREIGN KEY (message_id) REFERENCES message (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649537A1329 ON user (message_id)');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F2F23775F');
        $this->addSql('DROP INDEX IDX_B6BD307F2F23775F ON message');
        $this->addSql('ALTER TABLE message DROP likes_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE message ADD likes_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F2F23775F FOREIGN KEY (likes_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_B6BD307F2F23775F ON message (likes_id)');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649537A1329');
        $this->addSql('DROP INDEX IDX_8D93D649537A1329 ON user');
        $this->addSql('ALTER TABLE user DROP message_id');
    }
}
