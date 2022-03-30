<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220328153957 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE work (id INT AUTO_INCREMENT NOT NULL, company_id INT NOT NULL, contract_id INT NOT NULL, location_id INT NOT NULL, title VARCHAR(255) NOT NULL, picture LONGTEXT NOT NULL, time VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, INDEX IDX_534E6880979B1AD6 (company_id), INDEX IDX_534E68802576E0FD (contract_id), INDEX IDX_534E688064D218E (location_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE work ADD CONSTRAINT FK_534E6880979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE work ADD CONSTRAINT FK_534E68802576E0FD FOREIGN KEY (contract_id) REFERENCES contract (id)');
        $this->addSql('ALTER TABLE work ADD CONSTRAINT FK_534E688064D218E FOREIGN KEY (location_id) REFERENCES location (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE work');
    }
}
