<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230506094957 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE confirm_trip DROP FOREIGN KEY FK_EA0AC2AFA76ED395');
        $this->addSql('ALTER TABLE confirm_trip DROP FOREIGN KEY FK_EA0AC2AFA5BC2E0E');
        $this->addSql('DROP TABLE confirm_trip');
        $this->addSql('ALTER TABLE applied_trip ADD status INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE confirm_trip (id INT AUTO_INCREMENT NOT NULL, trip_id INT DEFAULT NULL, user_id INT DEFAULT NULL, INDEX IDX_EA0AC2AFA76ED395 (user_id), INDEX IDX_EA0AC2AFA5BC2E0E (trip_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE confirm_trip ADD CONSTRAINT FK_EA0AC2AFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE confirm_trip ADD CONSTRAINT FK_EA0AC2AFA5BC2E0E FOREIGN KEY (trip_id) REFERENCES trip (id)');
        $this->addSql('ALTER TABLE applied_trip DROP status');
    }
}
