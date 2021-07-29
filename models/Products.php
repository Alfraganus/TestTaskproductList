<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "products".
 *
 * @property int $id
 * @property string $image
 * @property string $sku
 * @property string $title
 * @property int|null $product_type
 *
 * @property ProductWarehouse[] $productWarehouses
 * @property ProductTypes $productType
 */
class Products extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'products';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [[ 'sku', 'title'], 'required'],
            [['product_type'], 'integer'],
            [['image'], 'file'],
            [[ 'sku', 'title'], 'string', 'max' => 255],
            [['product_type'], 'exist', 'skipOnError' => true, 'targetClass' => ProductTypes::className(), 'targetAttribute' => ['product_type' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'image' => 'Image',
            'sku' => 'Sku',
            'title' => 'Title',
            'product_type' => 'Product Type',
        ];
    }

    /**
     * Gets query for [[ProductWarehouses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductWarehouses()
    {
        return $this->hasOne(ProductWarehouse::className(), ['product_id' => 'id']);
    }

    /**
     * Gets query for [[ProductType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductType()
    {
        return $this->hasOne(ProductTypes::className(), ['id' => 'product_type']);
    }
}
