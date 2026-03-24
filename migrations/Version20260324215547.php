<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260324215547 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE command_line (id INT AUTO_INCREMENT NOT NULL, quantity DOUBLE PRECISION NOT NULL, product_id INT DEFAULT NULL, order_numb_id INT DEFAULT NULL, INDEX IDX_70BE1A7B4584665A (product_id), INDEX IDX_70BE1A7B82FD4DA9 (order_numb_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE command_line ADD CONSTRAINT FK_70BE1A7B4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE command_line ADD CONSTRAINT FK_70BE1A7B82FD4DA9 FOREIGN KEY (order_numb_id) REFERENCES `order` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE command_line DROP FOREIGN KEY FK_70BE1A7B4584665A');
        $this->addSql('ALTER TABLE command_line DROP FOREIGN KEY FK_70BE1A7B82FD4DA9');
        $this->addSql('DROP TABLE command_line');
    }
}
