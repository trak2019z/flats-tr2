<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190410105614 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE flat ADD city_id INT NOT NULL, ADD address VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE flat ADD CONSTRAINT FK_554AAA448BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
        $this->addSql('CREATE INDEX IDX_554AAA448BAC62AF ON flat (city_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE flat DROP FOREIGN KEY FK_554AAA448BAC62AF');
        $this->addSql('DROP INDEX IDX_554AAA448BAC62AF ON flat');
        $this->addSql('ALTER TABLE flat DROP city_id, DROP address');
    }
}
