<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240529091420 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE districts (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE otv (id INT AUTO_INCREMENT NOT NULL, residents_id INT NOT NULL, start_date DATE NOT NULL, end_date DATE NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', data JSON DEFAULT NULL COMMENT \'(DC2Type:json)\', path_to_file VARCHAR(255) DEFAULT NULL, file_name VARCHAR(255) DEFAULT NULL, comments VARCHAR(255) DEFAULT NULL, status VARCHAR(255) NOT NULL, INDEX IDX_4EFF3DF42C901C6C (residents_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE residents (id INT AUTO_INCREMENT NOT NULL, districts_id INT NOT NULL, civility VARCHAR(255) DEFAULT NULL, lastname VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, mobile_phone VARCHAR(255) NOT NULL, landline_phone VARCHAR(255) DEFAULT NULL, email VARCHAR(255) NOT NULL, street VARCHAR(255) NOT NULL, street_number VARCHAR(255) DEFAULT NULL, additional_street_number VARCHAR(255) DEFAULT NULL, additional_address_info VARCHAR(255) DEFAULT NULL, INDEX IDX_F27069E459CA2297 (districts_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE otv ADD CONSTRAINT FK_4EFF3DF42C901C6C FOREIGN KEY (residents_id) REFERENCES residents (id)');
        $this->addSql('ALTER TABLE residents ADD CONSTRAINT FK_F27069E459CA2297 FOREIGN KEY (districts_id) REFERENCES districts (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE otv DROP FOREIGN KEY FK_4EFF3DF42C901C6C');
        $this->addSql('ALTER TABLE residents DROP FOREIGN KEY FK_F27069E459CA2297');
        $this->addSql('DROP TABLE districts');
        $this->addSql('DROP TABLE otv');
        $this->addSql('DROP TABLE residents');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
