<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241211110106 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD enseignant_id INT DEFAULT NULL, ADD etudient_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649E455FCC0 FOREIGN KEY (enseignant_id) REFERENCES enseignant (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649467BF3B5 FOREIGN KEY (etudient_id) REFERENCES etudient (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E455FCC0 ON user (enseignant_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649467BF3B5 ON user (etudient_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649E455FCC0');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649467BF3B5');
        $this->addSql('DROP INDEX UNIQ_8D93D649E455FCC0 ON user');
        $this->addSql('DROP INDEX UNIQ_8D93D649467BF3B5 ON user');
        $this->addSql('ALTER TABLE user DROP enseignant_id, DROP etudient_id');
    }
}
