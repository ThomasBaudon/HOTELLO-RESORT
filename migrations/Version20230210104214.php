<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230210104214 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE35F83FFC');
        $this->addSql('DROP INDEX IDX_E00CEDDE54177093 ON booking');
        $this->addSql('ALTER TABLE booking CHANGE room_id room_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE35F83FFC FOREIGN KEY (room_id_id) REFERENCES room (id)');
        $this->addSql('CREATE INDEX IDX_E00CEDDE35F83FFC ON booking (room_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE35F83FFC');
        $this->addSql('DROP INDEX IDX_E00CEDDE35F83FFC ON booking');
        $this->addSql('ALTER TABLE booking CHANGE room_id_id room_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE35F83FFC FOREIGN KEY (room_id) REFERENCES room (id)');
        $this->addSql('CREATE INDEX IDX_E00CEDDE54177093 ON booking (room_id)');
    }
}
