<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230131102142 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, lastname_client VARCHAR(50) NOT NULL, firstname_client VARCHAR(50) NOT NULL, adress_client VARCHAR(150) NOT NULL, city_client VARCHAR(50) NOT NULL, zip_client VARCHAR(10) NOT NULL, phone_client VARCHAR(15) NOT NULL, birthdate_client DATETIME NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', country_client VARCHAR(50) NOT NULL, UNIQUE INDEX UNIQ_C7440455E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, lastname_contact VARCHAR(50) NOT NULL, firstname_contact VARCHAR(50) NOT NULL, email_contact VARCHAR(120) NOT NULL, message_contact LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employee (id INT AUTO_INCREMENT NOT NULL, lastname_employee VARCHAR(50) NOT NULL, firstname_employee VARCHAR(50) NOT NULL, job_employee VARCHAR(50) NOT NULL, photo_employee VARCHAR(255) DEFAULT NULL, arrival_date DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE equipment (id INT AUTO_INCREMENT NOT NULL, id_room_id INT DEFAULT NULL, icon VARCHAR(255) NOT NULL, name VARCHAR(50) NOT NULL, description_equipment LONGTEXT DEFAULT NULL, INDEX IDX_D338D5838A8AD9E3 (id_room_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE review (id INT AUTO_INCREMENT NOT NULL, id_client_id INT DEFAULT NULL, id_room_id INT DEFAULT NULL, review LONGTEXT NOT NULL, score INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_794381C699DED506 (id_client_id), INDEX IDX_794381C68A8AD9E3 (id_room_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE room (id INT AUTO_INCREMENT NOT NULL, title_room VARCHAR(25) NOT NULL, price_room INT NOT NULL, type_room VARCHAR(25) NOT NULL, size_room INT NOT NULL, description_room LONGTEXT NOT NULL, adults_cap INT NOT NULL, children_cap INT NOT NULL, status_room TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, name_service VARCHAR(50) NOT NULL, description_service LONGTEXT NOT NULL, image_service VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE equipment ADD CONSTRAINT FK_D338D5838A8AD9E3 FOREIGN KEY (id_room_id) REFERENCES room (id)');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C699DED506 FOREIGN KEY (id_client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C68A8AD9E3 FOREIGN KEY (id_room_id) REFERENCES room (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE equipment DROP FOREIGN KEY FK_D338D5838A8AD9E3');
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C699DED506');
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C68A8AD9E3');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE employee');
        $this->addSql('DROP TABLE equipment');
        $this->addSql('DROP TABLE review');
        $this->addSql('DROP TABLE room');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
