<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240923115008 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commande (id INT AUTO_INCREMENT NOT NULL, fournisseur_cmd_id INT DEFAULT NULL, commandes_detail_id INT DEFAULT NULL, numero INT NOT NULL, date_commande DATE NOT NULL, statut_commande VARCHAR(50) NOT NULL, INDEX IDX_6EEAA67DBE8E43FB (fournisseur_cmd_id), UNIQUE INDEX UNIQ_6EEAA67D81089350 (commandes_detail_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE detail_commande (id INT AUTO_INCREMENT NOT NULL, quantite INT NOT NULL, prix_unitaire DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evaluation (id INT AUTO_INCREMENT NOT NULL, fournisseur_eval_id INT DEFAULT NULL, user_eval_id INT DEFAULT NULL, note INT NOT NULL, commentaire VARCHAR(255) NOT NULL, INDEX IDX_1323A5757FB1729 (fournisseur_eval_id), INDEX IDX_1323A5758D36468E (user_eval_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fournisseur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, email VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produit (id INT AUTO_INCREMENT NOT NULL, produits_f_id INT DEFAULT NULL, produits_detail_id INT DEFAULT NULL, matricule_produit VARCHAR(50) NOT NULL, description VARCHAR(255) NOT NULL, prix_produit DOUBLE PRECISION NOT NULL, INDEX IDX_29A5EC27BBDEB923 (produits_f_id), INDEX IDX_29A5EC27B0F286BB (produits_detail_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, matricule VARCHAR(10) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DBE8E43FB FOREIGN KEY (fournisseur_cmd_id) REFERENCES fournisseur (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D81089350 FOREIGN KEY (commandes_detail_id) REFERENCES detail_commande (id)');
        $this->addSql('ALTER TABLE evaluation ADD CONSTRAINT FK_1323A5757FB1729 FOREIGN KEY (fournisseur_eval_id) REFERENCES fournisseur (id)');
        $this->addSql('ALTER TABLE evaluation ADD CONSTRAINT FK_1323A5758D36468E FOREIGN KEY (user_eval_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27BBDEB923 FOREIGN KEY (produits_f_id) REFERENCES fournisseur (id)');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27B0F286BB FOREIGN KEY (produits_detail_id) REFERENCES detail_commande (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DBE8E43FB');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D81089350');
        $this->addSql('ALTER TABLE evaluation DROP FOREIGN KEY FK_1323A5757FB1729');
        $this->addSql('ALTER TABLE evaluation DROP FOREIGN KEY FK_1323A5758D36468E');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27BBDEB923');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27B0F286BB');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE detail_commande');
        $this->addSql('DROP TABLE evaluation');
        $this->addSql('DROP TABLE fournisseur');
        $this->addSql('DROP TABLE produit');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
