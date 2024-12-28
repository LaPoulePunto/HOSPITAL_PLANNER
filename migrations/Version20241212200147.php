<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241212200147 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE availability DROP FOREIGN KEY FK_3FB7A2BFC387A778');
        $this->addSql('DROP INDEX IDX_3FB7A2BFC387A778 ON availability');
        $this->addSql('ALTER TABLE availability CHANGE healthprofessional_id health_professional_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE availability ADD CONSTRAINT FK_3FB7A2BFB7750F8C FOREIGN KEY (health_professional_id) REFERENCES health_professional (id)');
        $this->addSql('CREATE INDEX IDX_3FB7A2BFB7750F8C ON availability (health_professional_id)');
        $this->addSql('ALTER TABLE consultation DROP FOREIGN KEY FK_964685A6E0D2FC3D');
        $this->addSql('DROP INDEX IDX_964685A6E0D2FC3D ON consultation');
        $this->addSql('ALTER TABLE consultation CHANGE consultationtype_id consultation_type_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE consultation ADD CONSTRAINT FK_964685A6804F7D71 FOREIGN KEY (consultation_type_id) REFERENCES consultation_type (id)');
        $this->addSql('CREATE INDEX IDX_964685A6804F7D71 ON consultation (consultation_type_id)');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955C387A778');
        $this->addSql('DROP INDEX IDX_42C84955C387A778 ON reservation');
        $this->addSql('ALTER TABLE reservation CHANGE healthprofessional_id health_professional_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955B7750F8C FOREIGN KEY (health_professional_id) REFERENCES health_professional (id)');
        $this->addSql('CREATE INDEX IDX_42C84955B7750F8C ON reservation (health_professional_id)');
        $this->addSql('ALTER TABLE room DROP FOREIGN KEY FK_729F519B7D31ADD1');
        $this->addSql('DROP INDEX IDX_729F519B7D31ADD1 ON room');
        $this->addSql('ALTER TABLE room CHANGE roomtype_id room_type_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE room ADD CONSTRAINT FK_729F519B296E3073 FOREIGN KEY (room_type_id) REFERENCES room_type (id)');
        $this->addSql('CREATE INDEX IDX_729F519B296E3073 ON room (room_type_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE availability DROP FOREIGN KEY FK_3FB7A2BFB7750F8C');
        $this->addSql('DROP INDEX IDX_3FB7A2BFB7750F8C ON availability');
        $this->addSql('ALTER TABLE availability CHANGE health_professional_id healthprofessional_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE availability ADD CONSTRAINT FK_3FB7A2BFC387A778 FOREIGN KEY (healthprofessional_id) REFERENCES health_professional (id)');
        $this->addSql('CREATE INDEX IDX_3FB7A2BFC387A778 ON availability (healthprofessional_id)');
        $this->addSql('ALTER TABLE consultation DROP FOREIGN KEY FK_964685A6804F7D71');
        $this->addSql('DROP INDEX IDX_964685A6804F7D71 ON consultation');
        $this->addSql('ALTER TABLE consultation CHANGE consultation_type_id consultationtype_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE consultation ADD CONSTRAINT FK_964685A6E0D2FC3D FOREIGN KEY (consultationtype_id) REFERENCES consultation_type (id)');
        $this->addSql('CREATE INDEX IDX_964685A6E0D2FC3D ON consultation (consultationtype_id)');
        $this->addSql('ALTER TABLE room DROP FOREIGN KEY FK_729F519B296E3073');
        $this->addSql('DROP INDEX IDX_729F519B296E3073 ON room');
        $this->addSql('ALTER TABLE room CHANGE room_type_id roomtype_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE room ADD CONSTRAINT FK_729F519B7D31ADD1 FOREIGN KEY (roomtype_id) REFERENCES room_type (id)');
        $this->addSql('CREATE INDEX IDX_729F519B7D31ADD1 ON room (roomtype_id)');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955B7750F8C');
        $this->addSql('DROP INDEX IDX_42C84955B7750F8C ON reservation');
        $this->addSql('ALTER TABLE reservation CHANGE health_professional_id healthprofessional_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955C387A778 FOREIGN KEY (healthprofessional_id) REFERENCES health_professional (id)');
        $this->addSql('CREATE INDEX IDX_42C84955C387A778 ON reservation (healthprofessional_id)');
    }
}
