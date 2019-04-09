<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190402200342 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE flat_furniture_type');
        $this->addSql('ALTER TABLE flat ADD furnishings_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE flat ADD CONSTRAINT FK_554AAA44C836642F FOREIGN KEY (furnishings_id) REFERENCES furniture_type (id)');
        $this->addSql('CREATE INDEX IDX_554AAA44C836642F ON flat (furnishings_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE flat_furniture_type (flat_id INT NOT NULL, furniture_type_id INT NOT NULL, INDEX IDX_BB62A968D3331C94 (flat_id), INDEX IDX_BB62A96840AC7965 (furniture_type_id), PRIMARY KEY(flat_id, furniture_type_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE flat_furniture_type ADD CONSTRAINT FK_BB62A96840AC7965 FOREIGN KEY (furniture_type_id) REFERENCES furniture_type (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE flat_furniture_type ADD CONSTRAINT FK_BB62A968D3331C94 FOREIGN KEY (flat_id) REFERENCES flat (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE flat DROP FOREIGN KEY FK_554AAA44C836642F');
        $this->addSql('DROP INDEX IDX_554AAA44C836642F ON flat');
        $this->addSql('ALTER TABLE flat DROP furnishings_id');
    }
}
