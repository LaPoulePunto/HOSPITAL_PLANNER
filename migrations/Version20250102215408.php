<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250102215408 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // Add columns
        $this->addSql('ALTER TABLE consultation_type ADD speciality_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE consultation_type ADD room_type_id INT DEFAULT NULL');

        // Add default values
        $this->addSql('UPDATE consultation_type SET speciality_id = (SELECT id FROM speciality LIMIT 1) WHERE speciality_id IS NULL');
        $this->addSql('UPDATE consultation_type SET room_type_id = (SELECT id FROM room_type LIMIT 1) WHERE room_type_id IS NULL');

        // Alter table so speciality_id and room_type_id cannot be null
        $this->addSql('ALTER TABLE consultation_type MODIFY speciality_id INT NOT NULL');
        $this->addSql('ALTER TABLE consultation_type MODIFY room_type_id INT NOT NULL');

        // Add foreign key
        $this->addSql('ALTER TABLE consultation_type ADD CONSTRAINT FK_A717D7E33B5A08D7 FOREIGN KEY (speciality_id) REFERENCES speciality (id)');
        $this->addSql('ALTER TABLE consultation_type ADD CONSTRAINT FK_A717D7E3296E3073 FOREIGN KEY (room_type_id) REFERENCES room_type (id)');
        $this->addSql('CREATE INDEX IDX_A717D7E33B5A08D7 ON consultation_type (speciality_id)');
        $this->addSql('CREATE INDEX IDX_A717D7E3296E3073 ON consultation_type (room_type_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE consultation_type DROP FOREIGN KEY FK_A717D7E33B5A08D7');
        $this->addSql('ALTER TABLE consultation_type DROP FOREIGN KEY FK_A717D7E3296E3073');
        $this->addSql('DROP INDEX IDX_A717D7E33B5A08D7 ON consultation_type');
        $this->addSql('DROP INDEX IDX_A717D7E3296E3073 ON consultation_type');
        $this->addSql('ALTER TABLE consultation_type DROP speciality_id, DROP room_type_id');
    }
}
