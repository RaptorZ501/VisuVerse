<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230425092144 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE onglet ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE onglet ADD CONSTRAINT FK_C6BC0239A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_C6BC0239A76ED395 ON onglet (user_id)');
        $this->addSql('ALTER TABLE user DROP mdp');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE onglet DROP FOREIGN KEY FK_C6BC0239A76ED395');
        $this->addSql('DROP INDEX IDX_C6BC0239A76ED395 ON onglet');
        $this->addSql('ALTER TABLE onglet DROP user_id');
        $this->addSql('ALTER TABLE user ADD mdp VARCHAR(255) NOT NULL');
    }
}
