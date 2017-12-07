<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171206033634 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE item_pedido (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', produto_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', pedido_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', quantidade DOUBLE PRECISION NOT NULL, preco_unitario DOUBLE PRECISION NOT NULL, percentual_desconto DOUBLE PRECISION NOT NULL, total DOUBLE PRECISION NOT NULL, UNIQUE INDEX UNIQ_42156301BF396750 (id), UNIQUE INDEX UNIQ_42156301105CFD56 (produto_id), INDEX IDX_421563014854653A (pedido_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pedido (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', cliente_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', numero INT NOT NULL, dataemissao DATE NOT NULL, total DOUBLE PRECISION NOT NULL, UNIQUE INDEX UNIQ_C4EC16CEBF396750 (id), UNIQUE INDEX UNIQ_C4EC16CEF55AE19E (numero), UNIQUE INDEX UNIQ_C4EC16CEDE734E51 (cliente_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE item_pedido ADD CONSTRAINT FK_42156301105CFD56 FOREIGN KEY (produto_id) REFERENCES produto (id)');
        $this->addSql('ALTER TABLE item_pedido ADD CONSTRAINT FK_421563014854653A FOREIGN KEY (pedido_id) REFERENCES pedido (id)');
        $this->addSql('ALTER TABLE pedido ADD CONSTRAINT FK_C4EC16CEDE734E51 FOREIGN KEY (cliente_id) REFERENCES pessoa (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE item_pedido DROP FOREIGN KEY FK_421563014854653A');
        $this->addSql('DROP TABLE item_pedido');
        $this->addSql('DROP TABLE pedido');
    }
}
