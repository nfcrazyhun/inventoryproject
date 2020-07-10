<?php

namespace app\models;

use yii\helpers\ArrayHelper;
use yii2mod\collection\Collection;

/**
 * This is the model class for table "categories".
 *
 * @property int $id
 * @property string|null $name
 * @property Workpiece[] $workpieces
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'categories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'],'string', 'max' => 255],
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
        ];
    }

    public static function getCategories()
    {
        $categories = self::find()->all();
        //$list = Collection::make($categories)->pluck('name','id')->toArray();

        $list = ArrayHelper::map($categories, 'id', 'name');

        return $list;
    }

    //==================================================================
    //Relationships

    /**
     * Gets query for [[Workpiece]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWorkpieces()
    {
        return $this->hasMany(Workpiece::className(), ['category_id' => 'id']);
    }
}
