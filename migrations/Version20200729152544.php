<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;



final class Version20200729152544 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('INSERT INTO category (id, title, parent_id) VALUES(1, "Комплектующие", null), (2, "Периферия", null), (3, "Аксессуары", null)');
        $this->addSql('INSERT INTO category (id, title, parent_id) VALUES(4 ,"Видеокарты", 1),(5, "Процессоры", 1),(6,"Память", 1),(7,"Материнские платы", 1),(8,"Блоки питания", 1),(9,"Корпуса", 1),(10,"Системы охлаждения", 1)');
        $this->addSql('INSERT INTO category (id, title, parent_id) VALUES(11 ,"Мониторы", 2),(12, "Мыши", 2),(13,"Клавиатуры", 2),(14,"Наушники", 2),(15,"Веб-камеры", 2)');
        $this->addSql('INSERT INTO category (id, title, parent_id) VALUES(16 ,"Переходники", 3),(17, "Кабели", 3),(18,"Внешние жесткие диски", 3),(19,"Флешки USB", 3)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DELETE FROM category WHERE id IN (4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19)');
        $this->addSql('DELETE FROM category WHERE id IN (1,2,3)');
    }
}