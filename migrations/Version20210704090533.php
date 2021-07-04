<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210704090533 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE shifts ADD adminuser_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE shifts ADD CONSTRAINT FK_1D1D712F39505EF FOREIGN KEY (adminuser_id) REFERENCES admin_user (id)');
        $this->addSql('CREATE INDEX IDX_1D1D712F39505EF ON shifts (adminuser_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE shifts DROP FOREIGN KEY FK_1D1D712F39505EF');
        $this->addSql('DROP INDEX IDX_1D1D712F39505EF ON shifts');
        $this->addSql('ALTER TABLE shifts DROP adminuser_id');
    }
}
