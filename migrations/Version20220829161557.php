<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220829161557 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE etudiant (id INT AUTO_INCREMENT NOT NULL, fillier_id INT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, numero INT NOT NULL, telephone VARCHAR(255) NOT NULL, scolariter_payer INT NOT NULL, inscription_payer TINYINT(1) NOT NULL, INDEX IDX_717E22E322FE6A41 (fillier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fillier (id INT AUTO_INCREMENT NOT NULL, promotion_id INT NOT NULL, nom VARCHAR(255) NOT NULL, niveau INT NOT NULL, scolariter_apayer INT NOT NULL, INDEX IDX_96445599139DF194 (promotion_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE presence (id INT AUTO_INCREMENT NOT NULL, prof_id INT NOT NULL, promotion_id INT NOT NULL, fillier_id INT NOT NULL, liste LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', date DATETIME NOT NULL, INDEX IDX_6977C7A5ABC1F7FE (prof_id), INDEX IDX_6977C7A5139DF194 (promotion_id), INDEX IDX_6977C7A522FE6A41 (fillier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE prof (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_5BBA70BBE7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE promotion (id INT AUTO_INCREMENT NOT NULL, annee DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, autoriser TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE etudiant ADD CONSTRAINT FK_717E22E322FE6A41 FOREIGN KEY (fillier_id) REFERENCES fillier (id)');
        $this->addSql('ALTER TABLE fillier ADD CONSTRAINT FK_96445599139DF194 FOREIGN KEY (promotion_id) REFERENCES promotion (id)');
        $this->addSql('ALTER TABLE presence ADD CONSTRAINT FK_6977C7A5ABC1F7FE FOREIGN KEY (prof_id) REFERENCES prof (id)');
        $this->addSql('ALTER TABLE presence ADD CONSTRAINT FK_6977C7A5139DF194 FOREIGN KEY (promotion_id) REFERENCES promotion (id)');
        $this->addSql('ALTER TABLE presence ADD CONSTRAINT FK_6977C7A522FE6A41 FOREIGN KEY (fillier_id) REFERENCES fillier (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE etudiant DROP FOREIGN KEY FK_717E22E322FE6A41');
        $this->addSql('ALTER TABLE fillier DROP FOREIGN KEY FK_96445599139DF194');
        $this->addSql('ALTER TABLE presence DROP FOREIGN KEY FK_6977C7A5ABC1F7FE');
        $this->addSql('ALTER TABLE presence DROP FOREIGN KEY FK_6977C7A5139DF194');
        $this->addSql('ALTER TABLE presence DROP FOREIGN KEY FK_6977C7A522FE6A41');
        $this->addSql('DROP TABLE etudiant');
        $this->addSql('DROP TABLE fillier');
        $this->addSql('DROP TABLE presence');
        $this->addSql('DROP TABLE prof');
        $this->addSql('DROP TABLE promotion');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
