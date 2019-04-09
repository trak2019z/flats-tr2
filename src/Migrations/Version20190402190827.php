<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190402190827 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE flat (id INT AUTO_INCREMENT NOT NULL, flat_type_id INT DEFAULT NULL, building_type_id INT DEFAULT NULL, heating_type_id INT DEFAULT NULL, kitchen_type_id INT DEFAULT NULL, bathroom_type_id INT DEFAULT NULL, windows_type_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, title_canonical VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, description_canonical LONGTEXT NOT NULL, latitude DOUBLE PRECISION NOT NULL, longitude DOUBLE PRECISION NOT NULL, area DOUBLE PRECISION DEFAULT NULL, floor INT DEFAULT NULL, construction_year INT DEFAULT NULL, floors INT DEFAULT NULL, free_from DATE DEFAULT NULL, internet TINYINT(1) DEFAULT NULL, internet_bandwidth INT DEFAULT NULL, photos LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', first_name VARCHAR(255) DEFAULT NULL, email VARCHAR(255) NOT NULL, phone1 VARCHAR(255) NOT NULL, phone2 VARCHAR(255) DEFAULT NULL, INDEX IDX_554AAA44A1384468 (flat_type_id), INDEX IDX_554AAA44F28401B9 (building_type_id), INDEX IDX_554AAA44AEA01003 (heating_type_id), INDEX IDX_554AAA44D14D6881 (kitchen_type_id), INDEX IDX_554AAA445C17BECB (bathroom_type_id), INDEX IDX_554AAA447DF59629 (windows_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE flat_furniture_type (flat_id INT NOT NULL, furniture_type_id INT NOT NULL, INDEX IDX_BB62A968D3331C94 (flat_id), INDEX IDX_BB62A96840AC7965 (furniture_type_id), PRIMARY KEY(flat_id, furniture_type_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE flat_equipment (flat_id INT NOT NULL, equipment_id INT NOT NULL, INDEX IDX_B1CFC303D3331C94 (flat_id), INDEX IDX_B1CFC303517FE9FE (equipment_id), PRIMARY KEY(flat_id, equipment_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE flat_flat_preference (flat_id INT NOT NULL, flat_preference_id INT NOT NULL, INDEX IDX_114183CFD3331C94 (flat_id), INDEX IDX_114183CFD5A33C37 (flat_preference_id), PRIMARY KEY(flat_id, flat_preference_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE flat ADD CONSTRAINT FK_554AAA44A1384468 FOREIGN KEY (flat_type_id) REFERENCES flat_type (id)');
        $this->addSql('ALTER TABLE flat ADD CONSTRAINT FK_554AAA44F28401B9 FOREIGN KEY (building_type_id) REFERENCES building_type (id)');
        $this->addSql('ALTER TABLE flat ADD CONSTRAINT FK_554AAA44AEA01003 FOREIGN KEY (heating_type_id) REFERENCES heating_type (id)');
        $this->addSql('ALTER TABLE flat ADD CONSTRAINT FK_554AAA44D14D6881 FOREIGN KEY (kitchen_type_id) REFERENCES kitchen_type (id)');
        $this->addSql('ALTER TABLE flat ADD CONSTRAINT FK_554AAA445C17BECB FOREIGN KEY (bathroom_type_id) REFERENCES bathroom_type (id)');
        $this->addSql('ALTER TABLE flat ADD CONSTRAINT FK_554AAA447DF59629 FOREIGN KEY (windows_type_id) REFERENCES windows_type (id)');
        $this->addSql('ALTER TABLE flat_furniture_type ADD CONSTRAINT FK_BB62A968D3331C94 FOREIGN KEY (flat_id) REFERENCES flat (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE flat_furniture_type ADD CONSTRAINT FK_BB62A96840AC7965 FOREIGN KEY (furniture_type_id) REFERENCES furniture_type (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE flat_equipment ADD CONSTRAINT FK_B1CFC303D3331C94 FOREIGN KEY (flat_id) REFERENCES flat (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE flat_equipment ADD CONSTRAINT FK_B1CFC303517FE9FE FOREIGN KEY (equipment_id) REFERENCES equipment (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE flat_flat_preference ADD CONSTRAINT FK_114183CFD3331C94 FOREIGN KEY (flat_id) REFERENCES flat (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE flat_flat_preference ADD CONSTRAINT FK_114183CFD5A33C37 FOREIGN KEY (flat_preference_id) REFERENCES flat_preference (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE room ADD flat_id INT NOT NULL');
        $this->addSql('ALTER TABLE room ADD CONSTRAINT FK_729F519BD3331C94 FOREIGN KEY (flat_id) REFERENCES flat (id)');
        $this->addSql('CREATE INDEX IDX_729F519BD3331C94 ON room (flat_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE flat_furniture_type DROP FOREIGN KEY FK_BB62A968D3331C94');
        $this->addSql('ALTER TABLE flat_equipment DROP FOREIGN KEY FK_B1CFC303D3331C94');
        $this->addSql('ALTER TABLE flat_flat_preference DROP FOREIGN KEY FK_114183CFD3331C94');
        $this->addSql('ALTER TABLE room DROP FOREIGN KEY FK_729F519BD3331C94');
        $this->addSql('DROP TABLE flat');
        $this->addSql('DROP TABLE flat_furniture_type');
        $this->addSql('DROP TABLE flat_equipment');
        $this->addSql('DROP TABLE flat_flat_preference');
        $this->addSql('DROP INDEX IDX_729F519BD3331C94 ON room');
        $this->addSql('ALTER TABLE room DROP flat_id');
    }
}
