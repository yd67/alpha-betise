<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210320015448 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE events_participant (id INT AUTO_INCREMENT NOT NULL, evenement_id INT NOT NULL, nom VARCHAR(40) NOT NULL, prenom VARCHAR(40) NOT NULL, email VARCHAR(255) NOT NULL, INDEX IDX_4DF52112FD02F13 (evenement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE events_participant ADD CONSTRAINT FK_4DF52112FD02F13 FOREIGN KEY (evenement_id) REFERENCES evenements (id)');
        $this->addSql('DROP TABLE evens_participants');
        $this->addSql('ALTER TABLE evenements CHANGE reservation reservation TINYINT(1) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE evens_participants (id INT AUTO_INCREMENT NOT NULL, evenements_id INT DEFAULT NULL, INDEX IDX_F9B7D0A163C02CD4 (evenements_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE evens_participants ADD CONSTRAINT FK_F9B7D0A163C02CD4 FOREIGN KEY (evenements_id) REFERENCES evenements (id)');
        $this->addSql('DROP TABLE events_participant');
        $this->addSql('ALTER TABLE evenements CHANGE reservation reservation TINYINT(1) NOT NULL');
    }
}
