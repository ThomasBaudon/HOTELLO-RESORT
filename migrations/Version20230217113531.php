<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230217113531 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE booking_confirmation (id INT AUTO_INCREMENT NOT NULL, room_id INT DEFAULT NULL, user_id INT DEFAULT NULL, start_date DATETIME NOT NULL, end_date DATETIME NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', booking_status TINYINT(1) NOT NULL, adults_cap INT NOT NULL, children_cap INT NOT NULL, total_cost INT NOT NULL, INDEX IDX_AAA2F3F354177093 (room_id), INDEX IDX_AAA2F3F3A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE booking_confirmation ADD CONSTRAINT FK_AAA2F3F354177093 FOREIGN KEY (room_id) REFERENCES room (id)');
        $this->addSql('ALTER TABLE booking_confirmation ADD CONSTRAINT FK_AAA2F3F3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking_confirmation DROP FOREIGN KEY FK_AAA2F3F354177093');
        $this->addSql('ALTER TABLE booking_confirmation DROP FOREIGN KEY FK_AAA2F3F3A76ED395');
        $this->addSql('DROP TABLE booking_confirmation');
    }
}
