<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210704091607 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE shifts ADD positions_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE shifts ADD CONSTRAINT FK_1D1D712F7813DDAE FOREIGN KEY (positions_id) REFERENCES positions (id)');
        $this->addSql('CREATE INDEX IDX_1D1D712F7813DDAE ON shifts (positions_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE shifts DROP FOREIGN KEY FK_1D1D712F7813DDAE');
        $this->addSql('DROP INDEX IDX_1D1D712F7813DDAE ON shifts');
        $this->addSql('ALTER TABLE shifts DROP positions_id');
    }
}
