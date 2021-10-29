<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211028070332 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_details DROP FOREIGN KEY FK_845CA2C1732E2069');
        $this->addSql('DROP INDEX IDX_845CA2C1732E2069 ON order_details');
        $this->addSql('ALTER TABLE order_details CHANGE myorder_id my_order_id INT NOT NULL');
        $this->addSql('ALTER TABLE order_details ADD CONSTRAINT FK_845CA2C1BFCDF877 FOREIGN KEY (my_order_id) REFERENCES `order` (id)');
        $this->addSql('CREATE INDEX IDX_845CA2C1BFCDF877 ON order_details (my_order_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_details DROP FOREIGN KEY FK_845CA2C1BFCDF877');
        $this->addSql('DROP INDEX IDX_845CA2C1BFCDF877 ON order_details');
        $this->addSql('ALTER TABLE order_details CHANGE my_order_id myorder_id INT NOT NULL');
        $this->addSql('ALTER TABLE order_details ADD CONSTRAINT FK_845CA2C1732E2069 FOREIGN KEY (myorder_id) REFERENCES `order` (id)');
        $this->addSql('CREATE INDEX IDX_845CA2C1732E2069 ON order_details (myorder_id)');
    }
}
