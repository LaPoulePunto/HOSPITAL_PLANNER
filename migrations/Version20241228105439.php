<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241228105439 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE availability_split_slots (id INT AUTO_INCREMENT NOT NULL, availability_id INT NOT NULL, start_time TIME NOT NULL, end_time TIME NOT NULL, date DATE NOT NULL, INDEX IDX_820ADD061778466 (availability_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE availability_split_slots ADD CONSTRAINT FK_820ADD061778466 FOREIGN KEY (availability_id) REFERENCES availability (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE availability_split_slots DROP FOREIGN KEY FK_820ADD061778466');
        $this->addSql('DROP TABLE availability_split_slots');
    }
}
