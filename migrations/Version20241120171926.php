<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241120171926 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE admin (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE availability (id INT AUTO_INCREMENT NOT NULL, healthprofessional_id INT DEFAULT NULL, date DATE NOT NULL, start_time TIME NOT NULL, end_time TIME NOT NULL, INDEX IDX_3FB7A2BFC387A778 (healthprofessional_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE consultation (id INT AUTO_INCREMENT NOT NULL, room_id INT DEFAULT NULL, consultationtype_id INT DEFAULT NULL, patient_id INT DEFAULT NULL, date DATE NOT NULL, start_time TIME NOT NULL, end_time TIME NOT NULL, INDEX IDX_964685A654177093 (room_id), INDEX IDX_964685A6E0D2FC3D (consultationtype_id), INDEX IDX_964685A66B899279 (patient_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE consultation_health_professional (consultation_id INT NOT NULL, health_professional_id INT NOT NULL, INDEX IDX_97DB84A262FF6CDF (consultation_id), INDEX IDX_97DB84A2B7750F8C (health_professional_id), PRIMARY KEY(consultation_id, health_professional_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE consultation_type (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(32) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE health_professional (id INT NOT NULL, job VARCHAR(32) NOT NULL, hiring_date DATE DEFAULT NULL, departure_date DATE DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE material (id INT AUTO_INCREMENT NOT NULL, room_id INT DEFAULT NULL, label VARCHAR(32) NOT NULL, INDEX IDX_7CBE759554177093 (room_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE patient (id INT NOT NULL, city VARCHAR(32) NOT NULL, post_code INT NOT NULL, phone VARCHAR(20) NOT NULL, address VARCHAR(128) DEFAULT NULL, blood_group VARCHAR(3) DEFAULT NULL, allergies VARCHAR(255) DEFAULT NULL, comments VARCHAR(255) DEFAULT NULL, treatments VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, material_id INT DEFAULT NULL, healthprofessional_id INT DEFAULT NULL, start_time DATETIME NOT NULL, end_time DATETIME NOT NULL, INDEX IDX_42C84955E308AC6F (material_id), INDEX IDX_42C84955C387A778 (healthprofessional_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE room (id INT AUTO_INCREMENT NOT NULL, roomtype_id INT DEFAULT NULL, num INT NOT NULL, floor VARCHAR(3) NOT NULL, INDEX IDX_729F519B7D31ADD1 (roomtype_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE room_type (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(32) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE speciality (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(32) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE speciality_health_professional (speciality_id INT NOT NULL, health_professional_id INT NOT NULL, INDEX IDX_E0234E4F3B5A08D7 (speciality_id), INDEX IDX_E0234E4FB7750F8C (health_professional_id), PRIMARY KEY(speciality_id, health_professional_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, lastname VARCHAR(32) DEFAULT NULL, firstname VARCHAR(32) DEFAULT NULL, login VARCHAR(32) DEFAULT NULL, gender INT DEFAULT NULL, is_verified TINYINT(1) NOT NULL, birth_date DATE NOT NULL, discriminator VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE admin ADD CONSTRAINT FK_880E0D76BF396750 FOREIGN KEY (id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE availability ADD CONSTRAINT FK_3FB7A2BFC387A778 FOREIGN KEY (healthprofessional_id) REFERENCES health_professional (id)');
        $this->addSql('ALTER TABLE consultation ADD CONSTRAINT FK_964685A654177093 FOREIGN KEY (room_id) REFERENCES room (id)');
        $this->addSql('ALTER TABLE consultation ADD CONSTRAINT FK_964685A6E0D2FC3D FOREIGN KEY (consultationtype_id) REFERENCES consultation_type (id)');
        $this->addSql('ALTER TABLE consultation ADD CONSTRAINT FK_964685A66B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE consultation_health_professional ADD CONSTRAINT FK_97DB84A262FF6CDF FOREIGN KEY (consultation_id) REFERENCES consultation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE consultation_health_professional ADD CONSTRAINT FK_97DB84A2B7750F8C FOREIGN KEY (health_professional_id) REFERENCES health_professional (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE health_professional ADD CONSTRAINT FK_40A5C32BF396750 FOREIGN KEY (id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE material ADD CONSTRAINT FK_7CBE759554177093 FOREIGN KEY (room_id) REFERENCES room (id)');
        $this->addSql('ALTER TABLE patient ADD CONSTRAINT FK_1ADAD7EBBF396750 FOREIGN KEY (id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955E308AC6F FOREIGN KEY (material_id) REFERENCES material (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955C387A778 FOREIGN KEY (healthprofessional_id) REFERENCES health_professional (id)');
        $this->addSql('ALTER TABLE room ADD CONSTRAINT FK_729F519B7D31ADD1 FOREIGN KEY (roomtype_id) REFERENCES room_type (id)');
        $this->addSql('ALTER TABLE speciality_health_professional ADD CONSTRAINT FK_E0234E4F3B5A08D7 FOREIGN KEY (speciality_id) REFERENCES speciality (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE speciality_health_professional ADD CONSTRAINT FK_E0234E4FB7750F8C FOREIGN KEY (health_professional_id) REFERENCES health_professional (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE admin DROP FOREIGN KEY FK_880E0D76BF396750');
        $this->addSql('ALTER TABLE availability DROP FOREIGN KEY FK_3FB7A2BFC387A778');
        $this->addSql('ALTER TABLE consultation DROP FOREIGN KEY FK_964685A654177093');
        $this->addSql('ALTER TABLE consultation DROP FOREIGN KEY FK_964685A6E0D2FC3D');
        $this->addSql('ALTER TABLE consultation DROP FOREIGN KEY FK_964685A66B899279');
        $this->addSql('ALTER TABLE consultation_health_professional DROP FOREIGN KEY FK_97DB84A262FF6CDF');
        $this->addSql('ALTER TABLE consultation_health_professional DROP FOREIGN KEY FK_97DB84A2B7750F8C');
        $this->addSql('ALTER TABLE health_professional DROP FOREIGN KEY FK_40A5C32BF396750');
        $this->addSql('ALTER TABLE material DROP FOREIGN KEY FK_7CBE759554177093');
        $this->addSql('ALTER TABLE patient DROP FOREIGN KEY FK_1ADAD7EBBF396750');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955E308AC6F');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955C387A778');
        $this->addSql('ALTER TABLE room DROP FOREIGN KEY FK_729F519B7D31ADD1');
        $this->addSql('ALTER TABLE speciality_health_professional DROP FOREIGN KEY FK_E0234E4F3B5A08D7');
        $this->addSql('ALTER TABLE speciality_health_professional DROP FOREIGN KEY FK_E0234E4FB7750F8C');
        $this->addSql('DROP TABLE admin');
        $this->addSql('DROP TABLE availability');
        $this->addSql('DROP TABLE consultation');
        $this->addSql('DROP TABLE consultation_health_professional');
        $this->addSql('DROP TABLE consultation_type');
        $this->addSql('DROP TABLE health_professional');
        $this->addSql('DROP TABLE material');
        $this->addSql('DROP TABLE patient');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE room');
        $this->addSql('DROP TABLE room_type');
        $this->addSql('DROP TABLE speciality');
        $this->addSql('DROP TABLE speciality_health_professional');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
