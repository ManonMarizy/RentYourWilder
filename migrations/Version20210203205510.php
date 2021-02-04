<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210203205510 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6496BF8E6F7');
        $this->addSql('DROP INDEX IDX_8D93D6496BF8E6F7 ON user');
        $this->addSql('ALTER TABLE user DROP wilder_id, CHANGE is_activate is_activate TINYINT(1) DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE wilder ADD user_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE wilder ADD CONSTRAINT FK_AB682D539D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_AB682D539D86650F ON wilder (user_id_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD wilder_id INT DEFAULT NULL, CHANGE is_activate is_activate TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6496BF8E6F7 FOREIGN KEY (wilder_id) REFERENCES wilder (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_8D93D6496BF8E6F7 ON user (wilder_id)');
        $this->addSql('ALTER TABLE wilder DROP FOREIGN KEY FK_AB682D539D86650F');
        $this->addSql('DROP INDEX IDX_AB682D539D86650F ON wilder');
        $this->addSql('ALTER TABLE wilder DROP user_id_id');
    }
}
