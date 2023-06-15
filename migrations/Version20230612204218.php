<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230612204218 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE page_project (id INT AUTO_INCREMENT NOT NULL, onglet_id_id INT DEFAULT NULL, user_id_id INT DEFAULT NULL, title_header VARCHAR(100) NOT NULL, title_base VARCHAR(100) NOT NULL, des_box1 VARCHAR(255) DEFAULT NULL, desbox2 VARCHAR(255) DEFAULT NULL, des_box3 VARCHAR(255) DEFAULT NULL, img_box1 VARCHAR(255) DEFAULT NULL, img_box2 VARCHAR(255) DEFAULT NULL, img_box3 VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_D5D33B7B6E4F6C1E (onglet_id_id), INDEX IDX_D5D33B7B9D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE page_project ADD CONSTRAINT FK_D5D33B7B6E4F6C1E FOREIGN KEY (onglet_id_id) REFERENCES onglet (id)');
        $this->addSql('ALTER TABLE page_project ADD CONSTRAINT FK_D5D33B7B9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE css_modifer DROP title_header, DROP title_base, DROP des_box1, DROP des_box2, DROP des_box3');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE page_project DROP FOREIGN KEY FK_D5D33B7B6E4F6C1E');
        $this->addSql('ALTER TABLE page_project DROP FOREIGN KEY FK_D5D33B7B9D86650F');
        $this->addSql('DROP TABLE page_project');
        $this->addSql('ALTER TABLE css_modifer ADD title_header VARCHAR(100) DEFAULT NULL, ADD title_base VARCHAR(100) NOT NULL, ADD des_box1 VARCHAR(255) DEFAULT NULL, ADD des_box2 VARCHAR(255) NOT NULL, ADD des_box3 VARCHAR(255) DEFAULT NULL');
    }
}
