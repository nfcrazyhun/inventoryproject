<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%workpieces}}`.
 */
class m200706_162853_create_workpieces_table extends Migration
{
    private $fk = 'fk_workpieces_category_id_categories_id';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%workpieces}}', [
            'id' => $this->primaryKey()->unsigned(),
            'name'=> $this->string(),
            'category_id' => $this->integer()->unsigned()->notNull(),
            'in_stock' => $this->integer()->unsigned(),
            'min_stock' => $this->integer()->unsigned(),
        ]);

        $this->addForeignKey(
            $this->fk,
            '{{%workpieces}}',
            'category_id',
            '{{%categories}}',
            'id'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            $this->fk,
            '{{%workpieces}}'
        );
        $this->dropTable('{{%workpieces}}');
    }
}
