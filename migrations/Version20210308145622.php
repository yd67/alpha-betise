<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210308145622 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE evenements (id INT AUTO_INCREMENT NOT NULL, img VARCHAR(255) NOT NULL, titre_evenements VARCHAR(255) NOT NULL, date_evenements DATE NOT NULL, lieux VARCHAR(60) DEFAULT NULL, reservation VARCHAR(40) NOT NULL, max_personne INT DEFAULT NULL, prix INT DEFAULT NULL, horaire VARCHAR(60) DEFAULT NULL, age_cible VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livres (id INT AUTO_INCREMENT NOT NULL, img VARCHAR(255) NOT NULL, titre VARCHAR(60) NOT NULL, auteur VARCHAR(60) NOT NULL, editeur VARCHAR(60) NOT NULL, prix INT NOT NULL, moyenne_avis SMALLINT DEFAULT NULL, avis_libraire LONGTEXT DEFAULT NULL, resume LONGTEXT DEFAULT NULL, stock INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(60) NOT NULL, prenom VARCHAR(60) NOT NULL, age DATE NOT NULL, img VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE evenements');
        $this->addSql('DROP TABLE livres');
        $this->addSql('DROP TABLE user');
    }
}
