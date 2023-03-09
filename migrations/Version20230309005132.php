<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230309005132 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E016BA31DB (delivered_at), INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE achat CHANGE id_user id_user INT DEFAULT NULL, CHANGE id_offre id_offre INT DEFAULT NULL');
        $this->addSql('ALTER TABLE admin CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE citoyen CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE demande_collecte CHANGE id_user id_user INT DEFAULT NULL, CHANGE id_poubelle id_poubelle INT DEFAULT NULL');
        $this->addSql('ALTER TABLE demande_poubelle CHANGE id_user id_user INT DEFAULT NULL');
        $this->addSql('ALTER TABLE details_demande CHANGE id_poubelle id_poubelle INT DEFAULT NULL, CHANGE id_demande_poubelle id_demande_poubelle INT DEFAULT NULL');
        $this->addSql('ALTER TABLE fiche_collecte CHANGE id_demande_collecte id_demande_collecte INT DEFAULT NULL, CHANGE id_user id_user INT DEFAULT NULL');
        $this->addSql('ALTER TABLE offre CHANGE id_categorie id_categorie INT DEFAULT NULL');
        $this->addSql('ALTER TABLE poubelle CHANGE id_type id_type INT DEFAULT NULL, CHANGE id_user id_user INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE id_user id_user INT AUTO_INCREMENT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('ALTER TABLE achat CHANGE id_user id_user INT NOT NULL, CHANGE id_offre id_offre INT NOT NULL');
        $this->addSql('ALTER TABLE admin CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE citoyen CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE demande_collecte CHANGE id_poubelle id_poubelle INT NOT NULL, CHANGE id_user id_user INT NOT NULL');
        $this->addSql('ALTER TABLE demande_poubelle CHANGE id_user id_user INT NOT NULL');
        $this->addSql('ALTER TABLE details_demande CHANGE id_demande_poubelle id_demande_poubelle INT NOT NULL, CHANGE id_poubelle id_poubelle INT NOT NULL');
        $this->addSql('ALTER TABLE fiche_collecte CHANGE id_demande_collecte id_demande_collecte INT NOT NULL, CHANGE id_user id_user INT NOT NULL');
        $this->addSql('ALTER TABLE offre CHANGE id_categorie id_categorie INT NOT NULL');
        $this->addSql('ALTER TABLE poubelle CHANGE id_user id_user INT NOT NULL, CHANGE id_type id_type INT NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE id_user id_user INT NOT NULL');
    }
}
