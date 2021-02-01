<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210201072215 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Initialisation de la base de données';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE account (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, fullname VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_7D3656A4E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE walk (id INT AUTO_INCREMENT NOT NULL, guide_id INT NOT NULL, title VARCHAR(255) NOT NULL, date DATETIME NOT NULL, description LONGTEXT NOT NULL, image VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, INDEX IDX_8D917A55D7ED1D4B (guide_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE walk_visitors (walk_id INT NOT NULL, account_id INT NOT NULL, INDEX IDX_BB7012B05EEE1B48 (walk_id), INDEX IDX_BB7012B09B6B5FBA (account_id), PRIMARY KEY(walk_id, account_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE walk ADD CONSTRAINT FK_8D917A55D7ED1D4B FOREIGN KEY (guide_id) REFERENCES account (id)');
        $this->addSql('ALTER TABLE walk_visitors ADD CONSTRAINT FK_BB7012B05EEE1B48 FOREIGN KEY (walk_id) REFERENCES walk (id)');
        $this->addSql('ALTER TABLE walk_visitors ADD CONSTRAINT FK_BB7012B09B6B5FBA FOREIGN KEY (account_id) REFERENCES account (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE walk DROP FOREIGN KEY FK_8D917A55D7ED1D4B');
        $this->addSql('ALTER TABLE walk_visitors DROP FOREIGN KEY FK_BB7012B09B6B5FBA');
        $this->addSql('ALTER TABLE walk_visitors DROP FOREIGN KEY FK_BB7012B05EEE1B48');
        $this->addSql('DROP TABLE account');
        $this->addSql('DROP TABLE walk');
        $this->addSql('DROP TABLE walk_visitors');
    }
}
