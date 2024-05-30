<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240530125133 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE address (id INT AUTO_INCREMENT NOT NULL, street VARCHAR(255) NOT NULL, street_number VARCHAR(255) DEFAULT NULL, additionnal_street_number VARCHAR(255) DEFAULT NULL, additional_address_info VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE otv ADD address_id INT NOT NULL, ADD district_id INT NOT NULL, ADD mobile_phone VARCHAR(255) NOT NULL, ADD landline_phone VARCHAR(255) DEFAULT NULL, ADD email VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE otv ADD CONSTRAINT FK_4EFF3DF4F5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE otv ADD CONSTRAINT FK_4EFF3DF4B08FA272 FOREIGN KEY (district_id) REFERENCES districts (id)');
        $this->addSql('CREATE INDEX IDX_4EFF3DF4F5B7AF75 ON otv (address_id)');
        $this->addSql('CREATE INDEX IDX_4EFF3DF4B08FA272 ON otv (district_id)');
        $this->addSql('ALTER TABLE residents DROP FOREIGN KEY FK_F27069E459CA2297');
        $this->addSql('DROP INDEX IDX_F27069E459CA2297 ON residents');
        $this->addSql('ALTER TABLE residents DROP districts_id, DROP mobile_phone, DROP landline_phone, DROP email, DROP street, DROP street_number, DROP additional_street_number, DROP additional_address_info');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE otv DROP FOREIGN KEY FK_4EFF3DF4F5B7AF75');
        $this->addSql('DROP TABLE address');
        $this->addSql('ALTER TABLE otv DROP FOREIGN KEY FK_4EFF3DF4B08FA272');
        $this->addSql('DROP INDEX IDX_4EFF3DF4F5B7AF75 ON otv');
        $this->addSql('DROP INDEX IDX_4EFF3DF4B08FA272 ON otv');
        $this->addSql('ALTER TABLE otv DROP address_id, DROP district_id, DROP mobile_phone, DROP landline_phone, DROP email');
        $this->addSql('ALTER TABLE residents ADD districts_id INT NOT NULL, ADD mobile_phone VARCHAR(255) NOT NULL, ADD landline_phone VARCHAR(255) DEFAULT NULL, ADD email VARCHAR(255) NOT NULL, ADD street VARCHAR(255) NOT NULL, ADD street_number VARCHAR(255) DEFAULT NULL, ADD additional_street_number VARCHAR(255) DEFAULT NULL, ADD additional_address_info VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE residents ADD CONSTRAINT FK_F27069E459CA2297 FOREIGN KEY (districts_id) REFERENCES districts (id)');
        $this->addSql('CREATE INDEX IDX_F27069E459CA2297 ON residents (districts_id)');
    }
}
