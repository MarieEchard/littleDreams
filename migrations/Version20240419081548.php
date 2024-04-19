<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240419081548 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user CHANGE nom_societe nom_societe VARCHAR(100) DEFAULT NULL, CHANGE no_rue no_rue VARCHAR(10) DEFAULT NULL, CHANGE rue rue VARCHAR(50) DEFAULT NULL, CHANGE code_postal code_postal VARCHAR(20) DEFAULT NULL, CHANGE ville ville VARCHAR(50) DEFAULT NULL, CHANGE no_siret no_siret VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE item_portfolio_categorie DROP FOREIGN KEY FK_283EF0DA7631AB82');
        $this->addSql('ALTER TABLE item_portfolio_categorie DROP FOREIGN KEY FK_283EF0DABCF5E72D');
        $this->addSql('ALTER TABLE projet DROP FOREIGN KEY FK_50159CA9BCF5E72D');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0AC18272');
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0AA76ED395');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494EA76ED395');
        $this->addSql('ALTER TABLE user CHANGE nom_societe nom_societe VARCHAR(100) NOT NULL, CHANGE no_siret no_siret VARCHAR(255) NOT NULL, CHANGE no_rue no_rue VARCHAR(10) NOT NULL, CHANGE rue rue VARCHAR(50) NOT NULL, CHANGE code_postal code_postal VARCHAR(20) NOT NULL, CHANGE ville ville VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE user_projet DROP FOREIGN KEY FK_35478794A76ED395');
        $this->addSql('ALTER TABLE user_projet DROP FOREIGN KEY FK_35478794C18272');
    }
}
