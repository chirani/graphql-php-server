<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260407080606 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE brands (id VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_7EA244345E237E06 (name), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE categories (id VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE currency (id VARCHAR(255) NOT NULL, label VARCHAR(255) NOT NULL, symbol VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE order_item_attributes (id INT AUTO_INCREMENT NOT NULL, order_item_id INT DEFAULT NULL, attribute_id INT DEFAULT NULL, attribute_value_id VARCHAR(255), INDEX IDX_47237526E415FB15 (order_item_id), INDEX IDX_47237526B6E62EFA (attribute_id), INDEX IDX_4723752665A22152 (attribute_value_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE order_items (id INT AUTO_INCREMENT NOT NULL, price_amount NUMERIC(10, 2) NOT NULL, quantity INT NOT NULL, order_id INT DEFAULT NULL, product_id VARCHAR(255), INDEX IDX_62809DB08D9F6D38 (order_id), INDEX IDX_62809DB04584665A (product_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE orders (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, createdAt DATETIME NOT NULL, currency_id VARCHAR(255), INDEX IDX_E52FFDEE38248176 (currency_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE prices (id INT AUTO_INCREMENT NOT NULL, amount DOUBLE PRECISION NOT NULL, product_id VARCHAR(255), currency_id VARCHAR(255), INDEX IDX_E4CB6D594584665A (product_id), INDEX IDX_E4CB6D5938248176 (currency_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE product_attribute_values (id VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL, display_value VARCHAR(255) NOT NULL, product_id VARCHAR(255), product_attribute_id INT NOT NULL, INDEX IDX_96CA06404584665A (product_id), INDEX IDX_96CA06403B420C91 (product_attribute_id), PRIMARY KEY (id, product_attribute_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE product_attributes (id INT AUTO_INCREMENT NOT NULL, sid VARCHAR(255) NOT NULL, product_id VARCHAR(255), INDEX IDX_A2FCC15B4584665A (product_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE product_contents (id INT AUTO_INCREMENT NOT NULL, position INT NOT NULL, product_content_uri VARCHAR(255) NOT NULL, product_id VARCHAR(255), INDEX IDX_7F4A7BE04584665A (product_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE products (id VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, inStock TINYINT NOT NULL, description Text, category_id VARCHAR(255), brand_id VARCHAR(255), INDEX IDX_B3BA5A5A12469DE2 (category_id), INDEX IDX_B3BA5A5A44F5D008 (brand_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE order_item_attributes ADD CONSTRAINT FK_47237526E415FB15 FOREIGN KEY (order_item_id) REFERENCES order_items (id)');
        $this->addSql('ALTER TABLE order_item_attributes ADD CONSTRAINT FK_47237526B6E62EFA FOREIGN KEY (attribute_id) REFERENCES product_attributes (id)');
        $this->addSql('ALTER TABLE order_item_attributes ADD CONSTRAINT FK_4723752665A22152 FOREIGN KEY (attribute_value_id) REFERENCES product_attribute_values (id)');
        $this->addSql('ALTER TABLE order_items ADD CONSTRAINT FK_62809DB08D9F6D38 FOREIGN KEY (order_id) REFERENCES orders (id)');
        $this->addSql('ALTER TABLE order_items ADD CONSTRAINT FK_62809DB04584665A FOREIGN KEY (product_id) REFERENCES products (id)');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEE38248176 FOREIGN KEY (currency_id) REFERENCES currency (id)');
        $this->addSql('ALTER TABLE prices ADD CONSTRAINT FK_E4CB6D594584665A FOREIGN KEY (product_id) REFERENCES products (id)');
        $this->addSql('ALTER TABLE prices ADD CONSTRAINT FK_E4CB6D5938248176 FOREIGN KEY (currency_id) REFERENCES currency (id)');
        $this->addSql('ALTER TABLE product_attribute_values ADD CONSTRAINT FK_96CA06404584665A FOREIGN KEY (product_id) REFERENCES products (id)');
        $this->addSql('ALTER TABLE product_attribute_values ADD CONSTRAINT FK_96CA06403B420C91 FOREIGN KEY (product_attribute_id) REFERENCES product_attributes (id)');
        $this->addSql('ALTER TABLE product_attributes ADD CONSTRAINT FK_A2FCC15B4584665A FOREIGN KEY (product_id) REFERENCES products (id)');
        $this->addSql('ALTER TABLE product_contents ADD CONSTRAINT FK_7F4A7BE04584665A FOREIGN KEY (product_id) REFERENCES products (id)');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT FK_B3BA5A5A12469DE2 FOREIGN KEY (category_id) REFERENCES categories (id)');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT FK_B3BA5A5A44F5D008 FOREIGN KEY (brand_id) REFERENCES brands (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_item_attributes DROP FOREIGN KEY FK_47237526E415FB15');
        $this->addSql('ALTER TABLE order_item_attributes DROP FOREIGN KEY FK_47237526B6E62EFA');
        $this->addSql('ALTER TABLE order_item_attributes DROP FOREIGN KEY FK_4723752665A22152');
        $this->addSql('ALTER TABLE order_items DROP FOREIGN KEY FK_62809DB08D9F6D38');
        $this->addSql('ALTER TABLE order_items DROP FOREIGN KEY FK_62809DB04584665A');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEE38248176');
        $this->addSql('ALTER TABLE prices DROP FOREIGN KEY FK_E4CB6D594584665A');
        $this->addSql('ALTER TABLE prices DROP FOREIGN KEY FK_E4CB6D5938248176');
        $this->addSql('ALTER TABLE product_attribute_values DROP FOREIGN KEY FK_96CA06404584665A');
        $this->addSql('ALTER TABLE product_attribute_values DROP FOREIGN KEY FK_96CA06403B420C91');
        $this->addSql('ALTER TABLE product_attributes DROP FOREIGN KEY FK_A2FCC15B4584665A');
        $this->addSql('ALTER TABLE product_contents DROP FOREIGN KEY FK_7F4A7BE04584665A');
        $this->addSql('ALTER TABLE products DROP FOREIGN KEY FK_B3BA5A5A12469DE2');
        $this->addSql('ALTER TABLE products DROP FOREIGN KEY FK_B3BA5A5A44F5D008');
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
