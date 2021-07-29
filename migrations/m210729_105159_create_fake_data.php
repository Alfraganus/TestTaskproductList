<?php

use app\models\Products;
use Faker\Factory;
use yii\db\Migration;
use app\models\ProductWarehouse;
use app\models\ProductTypes;
/**
 * Class m210729_105159_create_fake_data
 */
class m210729_105159_create_fake_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $bookCategories = [
            1=>'Local books',
            2=>'Internatinal books',
            3=>'Translated books',
        ];
        $bookNames = [
            1=>'Absalom, Absalom!',
            2=>'After Many a Summer Dies the Swan',
            3=>'Ah, Wilderness!',
            4=>'Alien Corn (play)!',
            5=>'All Passion Spent',
            6=>'All the King\'s Men',
            7=>'Alone on a Wide, Wide Sea',
            8=>'An Acceptable Time',
            9=>'Antic Hay',
            10=>'Arms and the Man',
            11=>'As I Lay Dying',
            12=>'Behold the Man',
            13=>'Beneath the Bleeding',
            14=>'Beyond the Mexique Bay',
            15=>'Blithe Spirit',
            16=>'Blood\'s a Rover',
            17=>'Blue Remembered Earth',
            18=>'Bonjour Tristesse',
            19=>'Bury My Heart at Wounded Knee',
            20=>'Butter In a Lordly Dish',
        ];


        for ($i=1;$i<=3;$i++) {
            $model = new ProductTypes();
            $model->title =$bookCategories[$i];
            $model->save(false);
        }

        for ($i=1;$i<=20;$i++) {
            $model = new Products();
            $model->image =$i.'.jpg';
            $model->sku = Yii::$app->security->generateRandomString(20);
            $model->title = $bookNames[$i];
            $model->product_type  = rand(1,3);
            $model->save(false);

            $productQuantity  = new ProductWarehouse();
            $productQuantity->product_id = $model->id;
            $productQuantity->quantity = rand(10,99);
            $productQuantity->save(false);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        Products::deleteAll();
        ProductTypes::deleteAll();
        ProductWarehouse::deleteAll();
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210729_105159_create_fake_data cannot be reverted.\n";

        return false;
    }
    */
}
