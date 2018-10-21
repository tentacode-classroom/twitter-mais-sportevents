<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181021134143 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE retweet (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, retweeted_message_id INT NOT NULL, INDEX IDX_45E67DB3A76ED395 (user_id), INDEX IDX_45E67DB37B65ABE9 (retweeted_message_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE retweet ADD CONSTRAINT FK_45E67DB3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE retweet ADD CONSTRAINT FK_45E67DB37B65ABE9 FOREIGN KEY (retweeted_message_id) REFERENCES message (id)');
        $this->addSql('ALTER TABLE message ADD image VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE retweet');
        $this->addSql('ALTER TABLE message DROP image');
    }
}
