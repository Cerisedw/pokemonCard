<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200326153524 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE ability (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, text VARCHAR(500) DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE attack (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, text VARCHAR(550) DEFAULT NULL, damage VARCHAR(255) DEFAULT NULL, converted_energy_cost INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE attack_type (attack_id INT NOT NULL, type_id INT NOT NULL, INDEX IDX_7BC596C4F5315759 (attack_id), INDEX IDX_7BC596C4C54C8C93 (type_id), PRIMARY KEY(attack_id, type_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE card (id INT AUTO_INCREMENT NOT NULL, weakness_id INT DEFAULT NULL, abilities_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, code VARCHAR(255) DEFAULT NULL, national_pokedex_number INT DEFAULT NULL, image_url VARCHAR(350) DEFAULT NULL, image_url_hi_res VARCHAR(350) DEFAULT NULL, supertype VARCHAR(255) DEFAULT NULL, hp VARCHAR(255) DEFAULT NULL, converted_retreat_cost INT DEFAULT NULL, number VARCHAR(255) DEFAULT NULL, artist VARCHAR(255) DEFAULT NULL, rarity VARCHAR(255) DEFAULT NULL, series VARCHAR(255) DEFAULT NULL, set_collection VARCHAR(255) DEFAULT NULL, set_code VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_161498D3908130BC (weakness_id), UNIQUE INDEX UNIQ_161498D31E1F6EAC (abilities_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE card_type (card_id INT NOT NULL, type_id INT NOT NULL, INDEX IDX_60ED558B4ACC9A20 (card_id), INDEX IDX_60ED558BC54C8C93 (type_id), PRIMARY KEY(card_id, type_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE card_attack (card_id INT NOT NULL, attack_id INT NOT NULL, INDEX IDX_35FF7E4F4ACC9A20 (card_id), INDEX IDX_35FF7E4FF5315759 (attack_id), PRIMARY KEY(card_id, attack_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE weakness (id INT AUTO_INCREMENT NOT NULL, typeweak_id INT DEFAULT NULL, value VARCHAR(255) DEFAULT NULL, INDEX IDX_6F883D49E70B1154 (typeweak_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE attack_type ADD CONSTRAINT FK_7BC596C4F5315759 FOREIGN KEY (attack_id) REFERENCES attack (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE attack_type ADD CONSTRAINT FK_7BC596C4C54C8C93 FOREIGN KEY (type_id) REFERENCES type (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE card ADD CONSTRAINT FK_161498D3908130BC FOREIGN KEY (weakness_id) REFERENCES weakness (id)');
        $this->addSql('ALTER TABLE card ADD CONSTRAINT FK_161498D31E1F6EAC FOREIGN KEY (abilities_id) REFERENCES ability (id)');
        $this->addSql('ALTER TABLE card_type ADD CONSTRAINT FK_60ED558B4ACC9A20 FOREIGN KEY (card_id) REFERENCES card (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE card_type ADD CONSTRAINT FK_60ED558BC54C8C93 FOREIGN KEY (type_id) REFERENCES type (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE card_attack ADD CONSTRAINT FK_35FF7E4F4ACC9A20 FOREIGN KEY (card_id) REFERENCES card (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE card_attack ADD CONSTRAINT FK_35FF7E4FF5315759 FOREIGN KEY (attack_id) REFERENCES attack (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE weakness ADD CONSTRAINT FK_6F883D49E70B1154 FOREIGN KEY (typeweak_id) REFERENCES type (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE card DROP FOREIGN KEY FK_161498D31E1F6EAC');
        $this->addSql('ALTER TABLE attack_type DROP FOREIGN KEY FK_7BC596C4F5315759');
        $this->addSql('ALTER TABLE card_attack DROP FOREIGN KEY FK_35FF7E4FF5315759');
        $this->addSql('ALTER TABLE card_type DROP FOREIGN KEY FK_60ED558B4ACC9A20');
        $this->addSql('ALTER TABLE card_attack DROP FOREIGN KEY FK_35FF7E4F4ACC9A20');
        $this->addSql('ALTER TABLE attack_type DROP FOREIGN KEY FK_7BC596C4C54C8C93');
        $this->addSql('ALTER TABLE card_type DROP FOREIGN KEY FK_60ED558BC54C8C93');
        $this->addSql('ALTER TABLE weakness DROP FOREIGN KEY FK_6F883D49E70B1154');
        $this->addSql('ALTER TABLE card DROP FOREIGN KEY FK_161498D3908130BC');
        $this->addSql('DROP TABLE ability');
        $this->addSql('DROP TABLE attack');
        $this->addSql('DROP TABLE attack_type');
        $this->addSql('DROP TABLE card');
        $this->addSql('DROP TABLE card_type');
        $this->addSql('DROP TABLE card_attack');
        $this->addSql('DROP TABLE type');
        $this->addSql('DROP TABLE weakness');
    }
}
