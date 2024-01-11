<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateProducts extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        $this->table('products')
             ->addColumn('name', 'string')
             ->addColumn('slug', 'string')
             ->addColumn('description', 'text', ['limit' => \Phinx\Db\Adapter\MysqlAdapter::TEXT_LONG])
             ->addColumn('image', 'string')
             ->addColumn('price', 'float', ['precision' => 6, 'scale' => 2])
             ->addColumn('created_at', 'datetime')
             ->addColumn('updated_at', 'datetime')
             ->addIndex('slug', ['unique' => true])
             ->create();
    }
}
