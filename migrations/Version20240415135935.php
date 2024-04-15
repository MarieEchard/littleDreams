<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240415135935 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs

        $this->addSql('ALTER TABLE question CHANGE question question VARCHAR(1000) NOT NULL, CHANGE reponse reponse VARCHAR(1000) DEFAULT NULL');
        $this->addSql('ALTER TABLE user_projet ADD CONSTRAINT FK_35478794A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_projet ADD CONSTRAINT FK_35478794C18272 FOREIGN KEY (projet_id) REFERENCES projet (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494EA76ED395');
        $this->addSql('ALTER TABLE question CHANGE question question VARCHAR(255) NOT NULL, CHANGE reponse reponse VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0AC18272');
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0AA76ED395');
        $this->addSql('ALTER TABLE projet_user DROP FOREIGN KEY FK_35478794A76ED395');
        $this->addSql('ALTER TABLE projet_user DROP FOREIGN KEY FK_35478794C18272');
        $this->addSql('ALTER TABLE projet DROP FOREIGN KEY FK_50159CA9BCF5E72D');
        $this->addSql('ALTER TABLE item_portfolio_categorie DROP FOREIGN KEY FK_283EF0DA7631AB82');
        $this->addSql('ALTER TABLE item_portfolio_categorie DROP FOREIGN KEY FK_283EF0DABCF5E72D');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
    }
}
