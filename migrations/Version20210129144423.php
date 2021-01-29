<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210129144423 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Ajout de la table de jointure des visitors à la table walk';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE walk_visitors (walk_id INT NOT NULL, account_id INT NOT NULL, INDEX IDX_BB7012B05EEE1B48 (walk_id), INDEX IDX_BB7012B09B6B5FBA (account_id), PRIMARY KEY(walk_id, account_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE walk_visitors ADD CONSTRAINT FK_BB7012B05EEE1B48 FOREIGN KEY (walk_id) REFERENCES walk (id)');
        $this->addSql('ALTER TABLE walk_visitors ADD CONSTRAINT FK_BB7012B09B6B5FBA FOREIGN KEY (account_id) REFERENCES account (id)');
        $this->addSql('ALTER TABLE walk CHANGE price price DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE walk RENAME INDEX fk_8d917a55d7ed1d4b TO IDX_8D917A55D7ED1D4B');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE walk_visitors');
        $this->addSql('ALTER TABLE walk CHANGE price price DOUBLE PRECISION DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE walk RENAME INDEX idx_8d917a55d7ed1d4b TO FK_8D917A55D7ED1D4B');
    }
}
