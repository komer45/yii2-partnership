<?php

namespace komer45\partnership\models;

use Yii;

/**
 * This is the model class for table "merch".
 *
 * @property integer $id
 * @property string $name
 * @property double $price
 * @property string $comment
 */
class Merch extends \yii\db\ActiveRecord implements \pistol88\cart\interfaces\CartElement
{
		
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'merch';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['price'], 'number'],
            [['comment'], 'string'],
            [['name'], 'string', 'max' => 55],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
   {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'price' => 'Price',
            'comment' => 'Comment',
        ];
    }
	
	
	public function getCartId()
    {
        return $this->id;
    }
	
	public function getId()		//без этой команды говорит, что в merch нет функции getId()
    {
        return $this->id;
    }

    public function getCartName()
    {
        return $this->name;
    }

    public function getCartPrice()
    {
        return $this->price;
    }

    //Опции продукта для выбора при добавлении в корзину
    public function getCartOptions()
    {
        return [
            '1' => [
                'name' => 'Цвет',
                'variants' => ['1' => 'Красный', '2' => 'Белый', '3' => 'Синий'],
            ],
            '2' => [
                'name' => 'Размер',
                'variants' => ['4' => 'XL', '5' => 'XS', '6' => 'XXL'],
            ]
        ];
    }
	
	
	public function minusAmount()
    {
        return NULL;
    }
	
}
