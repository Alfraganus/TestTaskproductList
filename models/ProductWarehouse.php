<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product_warehouse".
 *
 * @property int $id
 * @property int|null $product_id
 * @property int|null $quantity
 *
 * @property Products $product
 */
class ProductWarehouse extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_warehouse';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'quantity'], 'integer'],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Products::className(), 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'quantity' => 'Quantity',
        ];
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Products::className(), ['id' => 'product_id']);
    }
}
