<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210705111826 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE announcements DROP FOREIGN KEY FK_F422A9D39505EF');
        $this->addSql('DROP INDEX IDX_F422A9D39505EF ON announcements');
        $this->addSql('ALTER TABLE announcements ADD admin_user_id INT NOT NULL, DROP adminuser_id');
        $this->addSql('ALTER TABLE announcements ADD CONSTRAINT FK_F422A9D6352511C FOREIGN KEY (admin_user_id) REFERENCES admin_user (id)');
        $this->addSql('CREATE INDEX IDX_F422A9D6352511C ON announcements (admin_user_id)');
        $this->addSql('ALTER TABLE shifts DROP FOREIGN KEY FK_1D1D712F39505EF');
        $this->addSql('DROP INDEX IDX_1D1D712F39505EF ON shifts');
        $this->addSql('ALTER TABLE shifts ADD admin_user_id INT NOT NULL, DROP adminuser_id');
        $this->addSql('ALTER TABLE shifts ADD CONSTRAINT FK_1D1D712F6352511C FOREIGN KEY (admin_user_id) REFERENCES admin_user (id)');
        $this->addSql('CREATE INDEX IDX_1D1D712F6352511C ON shifts (admin_user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE announcements DROP FOREIGN KEY FK_F422A9D6352511C');
        $this->addSql('DROP INDEX IDX_F422A9D6352511C ON announcements');
        $this->addSql('ALTER TABLE announcements ADD adminuser_id INT DEFAULT NULL, DROP admin_user_id');
        $this->addSql('ALTER TABLE announcements ADD CONSTRAINT FK_F422A9D39505EF FOREIGN KEY (adminuser_id) REFERENCES admin_user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_F422A9D39505EF ON announcements (adminuser_id)');
        $this->addSql('ALTER TABLE shifts DROP FOREIGN KEY FK_1D1D712F6352511C');
        $this->addSql('DROP INDEX IDX_1D1D712F6352511C ON shifts');
        $this->addSql('ALTER TABLE shifts ADD adminuser_id INT DEFAULT NULL, DROP admin_user_id');
        $this->addSql('ALTER TABLE shifts ADD CONSTRAINT FK_1D1D712F39505EF FOREIGN KEY (adminuser_id) REFERENCES admin_user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_1D1D712F39505EF ON shifts (adminuser_id)');
    }
}
