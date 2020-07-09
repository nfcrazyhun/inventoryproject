<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%history}}`.
 */
class m200707_145217_create_history_table extends Migration
{
    private $fk = 'fk_history_workpiece_id_workpieces_id';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%history}}', [
            'id' => $this->primaryKey()->notNull(),
            'workpiece_id' => $this->integer()->unsigned()->notNull(),
            'quantity' => $this->integer(),
            'remark' => $this->string(),
            'created_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        $this->addForeignKey(
            $this->fk,
            '{{%history}}',
            'workpiece_id',
            '{{%workpieces}}',
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
            '{{%history}}'
        );

        $this->dropTable('{{%history}}');
    }
}
