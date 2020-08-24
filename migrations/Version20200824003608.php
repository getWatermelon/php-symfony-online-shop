<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200824003608 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADD44F05E5');
        $this->addSql('DROP TABLE product_images');
        $this->addSql('DROP INDEX UNIQ_D34A04ADD44F05E5 ON product');
        $this->addSql('ALTER TABLE product ADD images LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', DROP images_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product_images (id INT AUTO_INCREMENT NOT NULL, images LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:array)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE product ADD images_id INT DEFAULT NULL, DROP images');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADD44F05E5 FOREIGN KEY (images_id) REFERENCES product_images (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D34A04ADD44F05E5 ON product (images_id)');
    }
}
