<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200822202801 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product ADD images_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADD44F05E5 FOREIGN KEY (images_id) REFERENCES product_images (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D34A04ADD44F05E5 ON product (images_id)');
        $this->addSql('ALTER TABLE product_images DROP FOREIGN KEY FK_8263FFCE4584665A');
        $this->addSql('DROP INDEX IDX_8263FFCE4584665A ON product_images');
        $this->addSql('ALTER TABLE product_images DROP product_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADD44F05E5');
        $this->addSql('DROP INDEX UNIQ_D34A04ADD44F05E5 ON product');
        $this->addSql('ALTER TABLE product DROP images_id');
        $this->addSql('ALTER TABLE product_images ADD product_id INT NOT NULL');
        $this->addSql('ALTER TABLE product_images ADD CONSTRAINT FK_8263FFCE4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_8263FFCE4584665A ON product_images (product_id)');
    }
}
