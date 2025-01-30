<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250130192346 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE room (id INT AUTO_INCREMENT NOT NULL, user1_id INT NOT NULL, user2_id INT DEFAULT NULL, chat_id INT NOT NULL, state VARCHAR(255) NOT NULL, INDEX IDX_729F519B56AE248B (user1_id), INDEX IDX_729F519B441B8B65 (user2_id), INDEX IDX_729F519B1A9A7125 (chat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE room ADD CONSTRAINT FK_729F519B56AE248B FOREIGN KEY (user1_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE room ADD CONSTRAINT FK_729F519B441B8B65 FOREIGN KEY (user2_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE room ADD CONSTRAINT FK_729F519B1A9A7125 FOREIGN KEY (chat_id) REFERENCES chat (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE room DROP FOREIGN KEY FK_729F519B56AE248B');
        $this->addSql('ALTER TABLE room DROP FOREIGN KEY FK_729F519B441B8B65');
        $this->addSql('ALTER TABLE room DROP FOREIGN KEY FK_729F519B1A9A7125');
        $this->addSql('DROP TABLE room');
    }
}
