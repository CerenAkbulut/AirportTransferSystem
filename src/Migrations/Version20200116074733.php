<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200116074733 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE reservation CHANGE fromdest fromdest DATETIME DEFAULT NULL, CHANGE todest todest VARCHAR(255) DEFAULT NULL, CHANGE total total VARCHAR(255) DEFAULT NULL, CHANGE days days DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE cars ADD category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cars ADD CONSTRAINT FK_95C71D1412469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_95C71D1412469DE2 ON cars (category_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cars DROP FOREIGN KEY FK_95C71D1412469DE2');
        $this->addSql('DROP INDEX IDX_95C71D1412469DE2 ON cars');
        $this->addSql('ALTER TABLE cars DROP category_id');
        $this->addSql('ALTER TABLE reservation CHANGE fromdest fromdest VARCHAR(80) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE todest todest VARCHAR(80) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE total total DOUBLE PRECISION DEFAULT NULL, CHANGE days days INT DEFAULT NULL');
    }
}
