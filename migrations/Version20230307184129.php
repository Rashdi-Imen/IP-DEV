<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230307184129 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE achat DROP FOREIGN KEY achat_ibfk_1');
        $this->addSql('DROP INDEX id ON achat');
        $this->addSql('ALTER TABLE achat ADD id_user INT DEFAULT NULL, DROP id, CHANGE id_offre id_offre INT DEFAULT NULL');
        $this->addSql('ALTER TABLE achat ADD CONSTRAINT FK_26A984566B3CA4B FOREIGN KEY (id_user) REFERENCES user (id)');
        $this->addSql('CREATE INDEX id_user ON achat (id_user)');
        $this->addSql('ALTER TABLE demande_collecte DROP FOREIGN KEY demande_collecte_ibfk_1');
        $this->addSql('DROP INDEX id ON demande_collecte');
        $this->addSql('ALTER TABLE demande_collecte ADD id_user INT DEFAULT NULL, DROP id, CHANGE id_poubelle id_poubelle INT DEFAULT NULL');
        $this->addSql('ALTER TABLE demande_collecte ADD CONSTRAINT FK_13F703FF6B3CA4B FOREIGN KEY (id_user) REFERENCES user (id)');
        $this->addSql('CREATE INDEX id_user ON demande_collecte (id_user)');
        $this->addSql('ALTER TABLE demande_poubelle DROP FOREIGN KEY demande_poubelle_ibfk_1');
        $this->addSql('DROP INDEX id ON demande_poubelle');
        $this->addSql('ALTER TABLE demande_poubelle ADD id_user INT DEFAULT NULL, DROP id');
        $this->addSql('ALTER TABLE demande_poubelle ADD CONSTRAINT FK_F36D07616B3CA4B FOREIGN KEY (id_user) REFERENCES user (id)');
        $this->addSql('CREATE INDEX id_user ON demande_poubelle (id_user)');
        $this->addSql('ALTER TABLE details_demande CHANGE id_poubelle id_poubelle INT DEFAULT NULL, CHANGE id_demande_poubelle id_demande_poubelle INT DEFAULT NULL');
        $this->addSql('ALTER TABLE fiche_collecte DROP FOREIGN KEY fiche_collecte_ibfk_2');
        $this->addSql('DROP INDEX id ON fiche_collecte');
        $this->addSql('ALTER TABLE fiche_collecte ADD id_user INT DEFAULT NULL, DROP id, CHANGE id_demande_collecte id_demande_collecte INT DEFAULT NULL');
        $this->addSql('ALTER TABLE fiche_collecte ADD CONSTRAINT FK_33B070AC6B3CA4B FOREIGN KEY (id_user) REFERENCES user (id)');
        $this->addSql('CREATE INDEX id_user ON fiche_collecte (id_user)');
        $this->addSql('ALTER TABLE offre CHANGE id_categorie id_categorie INT DEFAULT NULL');
        $this->addSql('ALTER TABLE poubelle DROP FOREIGN KEY poubelle_ibfk_2');
        $this->addSql('DROP INDEX id ON poubelle');
        $this->addSql('ALTER TABLE poubelle ADD id_user INT DEFAULT NULL, DROP id, CHANGE id_type id_type INT DEFAULT NULL');
        $this->addSql('ALTER TABLE poubelle ADD CONSTRAINT FK_B5344EA36B3CA4B FOREIGN KEY (id_user) REFERENCES user (id)');
        $this->addSql('CREATE INDEX id_user ON poubelle (id_user)');
        $this->addSql('ALTER TABLE user DROP roles, DROP password, DROP nom, DROP prenom, DROP tel, DROP confirm_password, CHANGE email email VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('ALTER TABLE achat DROP FOREIGN KEY FK_26A984566B3CA4B');
        $this->addSql('DROP INDEX id_user ON achat');
        $this->addSql('ALTER TABLE achat ADD id INT NOT NULL, DROP id_user, CHANGE id_offre id_offre INT NOT NULL');
        $this->addSql('ALTER TABLE achat ADD CONSTRAINT achat_ibfk_1 FOREIGN KEY (id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX id ON achat (id)');
        $this->addSql('ALTER TABLE demande_collecte DROP FOREIGN KEY FK_13F703FF6B3CA4B');
        $this->addSql('DROP INDEX id_user ON demande_collecte');
        $this->addSql('ALTER TABLE demande_collecte ADD id INT NOT NULL, DROP id_user, CHANGE id_poubelle id_poubelle INT NOT NULL');
        $this->addSql('ALTER TABLE demande_collecte ADD CONSTRAINT demande_collecte_ibfk_1 FOREIGN KEY (id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX id ON demande_collecte (id)');
        $this->addSql('ALTER TABLE demande_poubelle DROP FOREIGN KEY FK_F36D07616B3CA4B');
        $this->addSql('DROP INDEX id_user ON demande_poubelle');
        $this->addSql('ALTER TABLE demande_poubelle ADD id INT NOT NULL, DROP id_user');
        $this->addSql('ALTER TABLE demande_poubelle ADD CONSTRAINT demande_poubelle_ibfk_1 FOREIGN KEY (id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX id ON demande_poubelle (id)');
        $this->addSql('ALTER TABLE details_demande CHANGE id_poubelle id_poubelle INT NOT NULL, CHANGE id_demande_poubelle id_demande_poubelle INT NOT NULL');
        $this->addSql('ALTER TABLE fiche_collecte DROP FOREIGN KEY FK_33B070AC6B3CA4B');
        $this->addSql('DROP INDEX id_user ON fiche_collecte');
        $this->addSql('ALTER TABLE fiche_collecte ADD id INT NOT NULL, DROP id_user, CHANGE id_demande_collecte id_demande_collecte INT NOT NULL');
        $this->addSql('ALTER TABLE fiche_collecte ADD CONSTRAINT fiche_collecte_ibfk_2 FOREIGN KEY (id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX id ON fiche_collecte (id)');
        $this->addSql('ALTER TABLE offre CHANGE id_categorie id_categorie INT NOT NULL');
        $this->addSql('ALTER TABLE poubelle DROP FOREIGN KEY FK_B5344EA36B3CA4B');
        $this->addSql('DROP INDEX id_user ON poubelle');
        $this->addSql('ALTER TABLE poubelle ADD id INT NOT NULL, DROP id_user, CHANGE id_type id_type INT NOT NULL');
        $this->addSql('ALTER TABLE poubelle ADD CONSTRAINT poubelle_ibfk_2 FOREIGN KEY (id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX id ON poubelle (id)');
        $this->addSql('ALTER TABLE user ADD roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', ADD password VARCHAR(255) NOT NULL, ADD nom VARCHAR(255) NOT NULL, ADD prenom VARCHAR(255) NOT NULL, ADD tel VARCHAR(255) NOT NULL, ADD confirm_password VARCHAR(255) NOT NULL, CHANGE email email VARCHAR(180) NOT NULL');
    }
}
