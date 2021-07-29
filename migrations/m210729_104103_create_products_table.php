<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%products}}`.
 */
class m210729_104103_create_products_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%products}}', [
            'id' => $this->primaryKey(),
            'image'=>$this->string(255)->notNull(),
            'sku'=>$this->string(255)->notNull(),
            'title'=>$this->string(255)->notNull(),
            'product_type'=>$this->integer()->null()
        ]);

        $this->createTable('{{%product_warehouse}}', [
            'id' => $this->primaryKey(),
            'product_id'=>$this->integer()->null(),
            'quantity'=>$this->integer()->null(),
        ]);

        $this->createTable('{{%product_types}}', [
            'id' => $this->primaryKey(),
            'title'=>$this->string(255)->null(),
        ]);

        $this->addForeignKey(
            'fk-product_warehouse-product_id',
            'product_warehouse',
            'product_id',
            'products',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-product_warehouse-product_type',
            'products',
            'product_type',
            'product_types',
            'id',
            'CASCADE'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-product_warehouse-product_id',
            'product_warehouse',
        );
        $this->dropForeignKey(
            'fk-product_warehouse-product_type',
            'products',
        );
        $this->dropTable('{{%products}}');
        $this->dropTable('{{%product_warehouse}}');
        $this->dropTable('{{%product_types}}');

    }
}
