<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260407065249 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE brands (id VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY (id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7EA244345E237E06 ON brands (name)');
        $this->addSql('CREATE TABLE categories (id VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY (id))');
        $this->addSql('CREATE TABLE currency (id VARCHAR(255) NOT NULL, label VARCHAR(255) NOT NULL, symbol VARCHAR(255) NOT NULL, PRIMARY KEY (id))');
        $this->addSql('CREATE TABLE order_item_attributes (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, order_item_id INTEGER DEFAULT NULL, attribute_id INTEGER DEFAULT NULL, attribute_value_id VARCHAR DEFAULT NULL, CONSTRAINT FK_47237526E415FB15 FOREIGN KEY (order_item_id) REFERENCES order_items (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_47237526B6E62EFA FOREIGN KEY (attribute_id) REFERENCES product_attributes (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_4723752665A22152 FOREIGN KEY (attribute_value_id) REFERENCES product_attribute_values (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_47237526E415FB15 ON order_item_attributes (order_item_id)');
        $this->addSql('CREATE INDEX IDX_47237526B6E62EFA ON order_item_attributes (attribute_id)');
        $this->addSql('CREATE INDEX IDX_4723752665A22152 ON order_item_attributes (attribute_value_id)');
        $this->addSql('CREATE TABLE order_items (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, price_amount NUMERIC(10, 2) NOT NULL, quantity INTEGER NOT NULL, order_id INTEGER DEFAULT NULL, product_id VARCHAR NOT NULL, CONSTRAINT FK_62809DB08D9F6D38 FOREIGN KEY (order_id) REFERENCES orders (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_62809DB04584665A FOREIGN KEY (product_id) REFERENCES products (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_62809DB08D9F6D38 ON order_items (order_id)');
        $this->addSql('CREATE INDEX IDX_62809DB04584665A ON order_items (product_id)');
        $this->addSql('CREATE TABLE orders (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, createdAt DATETIME NOT NULL, currency_id VARCHAR DEFAULT NULL, CONSTRAINT FK_E52FFDEE38248176 FOREIGN KEY (currency_id) REFERENCES currency (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_E52FFDEE38248176 ON orders (currency_id)');
        $this->addSql('CREATE TABLE prices (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, amount DOUBLE PRECISION NOT NULL, product_id VARCHAR NOT NULL, currency_id VARCHAR NOT NULL, CONSTRAINT FK_E4CB6D594584665A FOREIGN KEY (product_id) REFERENCES products (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_E4CB6D5938248176 FOREIGN KEY (currency_id) REFERENCES currency (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_E4CB6D594584665A ON prices (product_id)');
        $this->addSql('CREATE INDEX IDX_E4CB6D5938248176 ON prices (currency_id)');
        $this->addSql('CREATE TABLE product_attribute_values (id VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL, display_value VARCHAR(255) NOT NULL, product_id VARCHAR NOT NULL, product_attribute_id INTEGER NOT NULL, PRIMARY KEY (id, product_attribute_id), CONSTRAINT FK_96CA06404584665A FOREIGN KEY (product_id) REFERENCES products (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_96CA06403B420C91 FOREIGN KEY (product_attribute_id) REFERENCES product_attributes (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_96CA06404584665A ON product_attribute_values (product_id)');
        $this->addSql('CREATE INDEX IDX_96CA06403B420C91 ON product_attribute_values (product_attribute_id)');
        $this->addSql('CREATE TABLE product_attributes (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, sid VARCHAR(255) NOT NULL, product_id VARCHAR NOT NULL, CONSTRAINT FK_A2FCC15B4584665A FOREIGN KEY (product_id) REFERENCES products (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_A2FCC15B4584665A ON product_attributes (product_id)');
        $this->addSql('CREATE TABLE product_contents (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, position INTEGER NOT NULL, product_content_uri VARCHAR(255) NOT NULL, product_id VARCHAR NOT NULL, CONSTRAINT FK_7F4A7BE04584665A FOREIGN KEY (product_id) REFERENCES products (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_7F4A7BE04584665A ON product_contents (product_id)');
        $this->addSql('CREATE TABLE products (id VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, inStock BOOLEAN NOT NULL, description VARCHAR(255) NOT NULL, category_id VARCHAR NOT NULL, brand_id VARCHAR NOT NULL, PRIMARY KEY (id), CONSTRAINT FK_B3BA5A5A12469DE2 FOREIGN KEY (category_id) REFERENCES categories (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_B3BA5A5A44F5D008 FOREIGN KEY (brand_id) REFERENCES brands (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_B3BA5A5A12469DE2 ON products (category_id)');
        $this->addSql('CREATE INDEX IDX_B3BA5A5A44F5D008 ON products (brand_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE brands');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE currency');
        $this->addSql('DROP TABLE order_item_attributes');
        $this->addSql('DROP TABLE order_items');
        $this->addSql('DROP TABLE orders');
        $this->addSql('DROP TABLE prices');
        $this->addSql('DROP TABLE product_attribute_values');
        $this->addSql('DROP TABLE product_attributes');
        $this->addSql('DROP TABLE product_contents');
        $this->addSql('DROP TABLE products');
    }
}
