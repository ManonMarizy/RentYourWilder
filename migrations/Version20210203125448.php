<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210203125448 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE skill DROP FOREIGN KEY FK_5E3DE4776BF8E6F7');
        $this->addSql('DROP INDEX IDX_5E3DE4776BF8E6F7 ON skill');
        $this->addSql('ALTER TABLE skill DROP wilder_id');
        $this->addSql('ALTER TABLE wilder DROP FOREIGN KEY FK_AB682D535585C142');
        $this->addSql('DROP INDEX IDX_AB682D535585C142 ON wilder');
        $this->addSql('ALTER TABLE wilder DROP skill_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE skill ADD wilder_id INT NOT NULL');
        $this->addSql('ALTER TABLE skill ADD CONSTRAINT FK_5E3DE4776BF8E6F7 FOREIGN KEY (wilder_id) REFERENCES wilder (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_5E3DE4776BF8E6F7 ON skill (wilder_id)');
        $this->addSql('ALTER TABLE wilder ADD skill_id INT NOT NULL');
        $this->addSql('ALTER TABLE wilder ADD CONSTRAINT FK_AB682D535585C142 FOREIGN KEY (skill_id) REFERENCES skill (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_AB682D535585C142 ON wilder (skill_id)');
    }
}
