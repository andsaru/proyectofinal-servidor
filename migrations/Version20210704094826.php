<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210704094826 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE announcements ADD adminuser_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE announcements ADD CONSTRAINT FK_F422A9D39505EF FOREIGN KEY (adminuser_id) REFERENCES admin_user (id)');
        $this->addSql('CREATE INDEX IDX_F422A9D39505EF ON announcements (adminuser_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE announcements DROP FOREIGN KEY FK_F422A9D39505EF');
        $this->addSql('DROP INDEX IDX_F422A9D39505EF ON announcements');
        $this->addSql('ALTER TABLE announcements DROP adminuser_id');
    }
}
