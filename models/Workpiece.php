<?php

namespace app\models;

use Yii;
use yii2mod\collection\Collection;

/**
 * This is the model class for table "workpieces".
 *
 * @property int $id
 * @property string|null $name
 * @property int $category_id
 * @property int|null $in_stock
 * @property int|null $min_stock
 * @property Category $category
 * @property History $histories
 * @property History $deposits
 * @property History $withdraws
 */
class Workpiece extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'workpieces';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id'], 'required'],
            [['category_id', 'in_stock', 'min_stock'], 'integer'],
            [['min_stock'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            ['in_stock', 'default', 'value'=>0],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'category_id' => 'Category ID',
            'in_stock' => 'In Stock',
            'min_stock' => 'Min Stock',
        ];
    }

    //==================================================================
    //Relationships

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * Gets query for [[Histories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHistories()
    {
        return $this->hasMany(History::className(), ['workpiece_id' => 'id'])->orderBy('id DESC');
    }

    /**
     * Gets only the deposited [[Histories]]
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDeposits()
    {
        return $this->getHistories()->where( ['>', 'quantity', '0']);
    }

    /**
     * Gets only the withdraws [[Histories]]
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWithdraws()
    {
        return $this->getHistories()->where( ['<', 'quantity', '0']);
    }
}
