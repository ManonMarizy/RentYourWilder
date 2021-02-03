<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210203205603 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE wilder DROP FOREIGN KEY FK_AB682D539D86650F');
        $this->addSql('DROP INDEX IDX_AB682D539D86650F ON wilder');
        $this->addSql('ALTER TABLE wilder CHANGE user_id_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE wilder ADD CONSTRAINT FK_AB682D53A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_AB682D53A76ED395 ON wilder (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE wilder DROP FOREIGN KEY FK_AB682D53A76ED395');
        $this->addSql('DROP INDEX IDX_AB682D53A76ED395 ON wilder');
        $this->addSql('ALTER TABLE wilder CHANGE user_id user_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE wilder ADD CONSTRAINT FK_AB682D539D86650F FOREIGN KEY (user_id_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_AB682D539D86650F ON wilder (user_id_id)');
    }
}