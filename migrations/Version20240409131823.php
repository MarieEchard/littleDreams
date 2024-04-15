<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240409131823 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE item_portfolio (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, objectif_client VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE item_portfolio_categorie (item_portfolio_id INT NOT NULL, categorie_id INT NOT NULL, INDEX IDX_283EF0DA7631AB82 (item_portfolio_id), INDEX IDX_283EF0DABCF5E72D (categorie_id), PRIMARY KEY(item_portfolio_id, categorie_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE item_portfolio_categorie ADD CONSTRAINT FK_283EF0DA7631AB82 FOREIGN KEY (item_portfolio_id) REFERENCES item_portfolio (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE item_portfolio_categorie ADD CONSTRAINT FK_283EF0DABCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE item_portfolio_categorie DROP FOREIGN KEY FK_283EF0DA7631AB82');
        $this->addSql('ALTER TABLE item_portfolio_categorie DROP FOREIGN KEY FK_283EF0DABCF5E72D');
        $this->addSql('DROP TABLE item_portfolio');
        $this->addSql('DROP TABLE item_portfolio_categorie');
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0AC18272');
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0AA76ED395');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494EA76ED395');
        $this->addSql('ALTER TABLE projet DROP FOREIGN KEY FK_50159CA9BCF5E72D');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('ALTER TABLE user_projet DROP FOREIGN KEY FK_35478794A76ED395');
        $this->addSql('ALTER TABLE user_projet DROP FOREIGN KEY FK_35478794C18272');
    }
}
