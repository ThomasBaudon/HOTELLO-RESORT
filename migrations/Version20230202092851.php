<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230202092851 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY user_id');
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C68A8AD9E3');
        $this->addSql('DROP INDEX IDX_794381C699DED506 ON review');
        $this->addSql('DROP INDEX IDX_794381C68A8AD9E3 ON review');
        $this->addSql('ALTER TABLE review ADD id_user_id INT DEFAULT NULL, ADD id_room_id INT DEFAULT NULL, DROP user_id, DROP room_id');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C679F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C68A8AD9E3 FOREIGN KEY (id_room_id) REFERENCES room (id)');
        $this->addSql('CREATE INDEX IDX_794381C679F37AE5 ON review (id_user_id)');
        $this->addSql('CREATE INDEX IDX_794381C68A8AD9E3 ON review (id_room_id)');
        $this->addSql('ALTER TABLE user CHANGE birthdate_user birthdate_user DATETIME NOT NULL, CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C679F37AE5');
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C68A8AD9E3');
        $this->addSql('DROP INDEX IDX_794381C679F37AE5 ON review');
        $this->addSql('DROP INDEX IDX_794381C68A8AD9E3 ON review');
        $this->addSql('ALTER TABLE review ADD user_id INT DEFAULT NULL, ADD room_id INT DEFAULT NULL, DROP id_user_id, DROP id_room_id');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT user_id FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C68A8AD9E3 FOREIGN KEY (room_id) REFERENCES room (id)');
        $this->addSql('CREATE INDEX IDX_794381C699DED506 ON review (user_id)');
        $this->addSql('CREATE INDEX IDX_794381C68A8AD9E3 ON review (room_id)');
        $this->addSql('ALTER TABLE user CHANGE birthdate_user birthdate_user DATE NOT NULL, CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
    }
}
