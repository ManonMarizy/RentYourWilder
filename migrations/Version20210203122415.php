<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210203122415 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE skill (id INT AUTO_INCREMENT NOT NULL, wilder_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_5E3DE4776BF8E6F7 (wilder_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, wilder_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D6496BF8E6F7 (wilder_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE wilder (id INT AUTO_INCREMENT NOT NULL, skill_id INT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, is_available TINYINT(1) NOT NULL, is_enable TINYINT(1) NOT NULL, INDEX IDX_AB682D535585C142 (skill_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE wilder_has_skill (id INT AUTO_INCREMENT NOT NULL, wilders_id INT NOT NULL, skills_id INT NOT NULL, rate INT NOT NULL, INDEX IDX_8F1731F1C4C3227C (wilders_id), INDEX IDX_8F1731F17FF61858 (skills_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE skill ADD CONSTRAINT FK_5E3DE4776BF8E6F7 FOREIGN KEY (wilder_id) REFERENCES wilder (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6496BF8E6F7 FOREIGN KEY (wilder_id) REFERENCES wilder (id)');
        $this->addSql('ALTER TABLE wilder ADD CONSTRAINT FK_AB682D535585C142 FOREIGN KEY (skill_id) REFERENCES skill (id)');
        $this->addSql('ALTER TABLE wilder_has_skill ADD CONSTRAINT FK_8F1731F1C4C3227C FOREIGN KEY (wilders_id) REFERENCES wilder (id)');
        $this->addSql('ALTER TABLE wilder_has_skill ADD CONSTRAINT FK_8F1731F17FF61858 FOREIGN KEY (skills_id) REFERENCES skill (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE wilder DROP FOREIGN KEY FK_AB682D535585C142');
        $this->addSql('ALTER TABLE wilder_has_skill DROP FOREIGN KEY FK_8F1731F17FF61858');
        $this->addSql('ALTER TABLE skill DROP FOREIGN KEY FK_5E3DE4776BF8E6F7');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6496BF8E6F7');
        $this->addSql('ALTER TABLE wilder_has_skill DROP FOREIGN KEY FK_8F1731F1C4C3227C');
        $this->addSql('DROP TABLE skill');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE wilder');
        $this->addSql('DROP TABLE wilder_has_skill');
    }
}
