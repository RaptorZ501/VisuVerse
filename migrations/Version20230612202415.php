<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230612202415 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE css_modifer (id INT AUTO_INCREMENT NOT NULL, user_id_id INT DEFAULT NULL, bg_header VARCHAR(20) DEFAULT NULL, color_header VARCHAR(20) DEFAULT NULL, bg_base VARCHAR(20) DEFAULT NULL, bg_box1 VARCHAR(20) DEFAULT NULL, bg_box2 VARCHAR(20) DEFAULT NULL, bg_box3 VARCHAR(20) DEFAULT NULL, color_base VARCHAR(20) DEFAULT NULL, color_box1 VARCHAR(20) DEFAULT NULL, color_box2 VARCHAR(20) DEFAULT NULL, color_box3 VARCHAR(20) DEFAULT NULL, bg_nav VARCHAR(20) DEFAULT NULL, color_nav VARCHAR(20) DEFAULT NULL, title_header VARCHAR(100) DEFAULT NULL, title_base VARCHAR(100) NOT NULL, des_box1 VARCHAR(255) DEFAULT NULL, des_box2 VARCHAR(255) NOT NULL, des_box3 VARCHAR(255) DEFAULT NULL, INDEX IDX_2963A0FA9D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE css_modifer ADD CONSTRAINT FK_2963A0FA9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE onglet CHANGE title title VARCHAR(100) NOT NULL, CHANGE description description LONGTEXT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE css_modifer DROP FOREIGN KEY FK_2963A0FA9D86650F');
        $this->addSql('DROP TABLE css_modifer');
        $this->addSql('ALTER TABLE onglet CHANGE title title VARCHAR(100) DEFAULT NULL, CHANGE description description LONGTEXT DEFAULT NULL');
    }
}
