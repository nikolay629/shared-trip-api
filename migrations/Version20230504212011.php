<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230504212011 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE applied_trip (id INT AUTO_INCREMENT NOT NULL, trip_id INT DEFAULT NULL, user_id INT DEFAULT NULL, INDEX IDX_1200A470A5BC2E0E (trip_id), INDEX IDX_1200A470A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE confirm_trip (id INT AUTO_INCREMENT NOT NULL, trip_id INT DEFAULT NULL, user_id INT DEFAULT NULL, INDEX IDX_EA0AC2AFA5BC2E0E (trip_id), INDEX IDX_EA0AC2AFA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trip (id INT AUTO_INCREMENT NOT NULL, city_from VARCHAR(255) NOT NULL, city_to VARCHAR(255) NOT NULL, hour VARCHAR(255) NOT NULL, date VARCHAR(255) NOT NULL, seats VARCHAR(255) NOT NULL, price NUMERIC(10, 2) NOT NULL, comment VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE applied_trip ADD CONSTRAINT FK_1200A470A5BC2E0E FOREIGN KEY (trip_id) REFERENCES trip (id)');
        $this->addSql('ALTER TABLE applied_trip ADD CONSTRAINT FK_1200A470A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE confirm_trip ADD CONSTRAINT FK_EA0AC2AFA5BC2E0E FOREIGN KEY (trip_id) REFERENCES trip (id)');
        $this->addSql('ALTER TABLE confirm_trip ADD CONSTRAINT FK_EA0AC2AFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE applied_trip DROP FOREIGN KEY FK_1200A470A5BC2E0E');
        $this->addSql('ALTER TABLE applied_trip DROP FOREIGN KEY FK_1200A470A76ED395');
        $this->addSql('ALTER TABLE confirm_trip DROP FOREIGN KEY FK_EA0AC2AFA5BC2E0E');
        $this->addSql('ALTER TABLE confirm_trip DROP FOREIGN KEY FK_EA0AC2AFA76ED395');
        $this->addSql('DROP TABLE applied_trip');
        $this->addSql('DROP TABLE confirm_trip');
        $this->addSql('DROP TABLE trip');
    }
}
