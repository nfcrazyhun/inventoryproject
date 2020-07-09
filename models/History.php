<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "history".
 *
 * @property int $id
 * @property int $workpiece_id
 * @property int|null $quantity
 * @property string|null $remark
 * @property string|null $created_at
 *
 * //Relationships
 * @property Workpiece $workpiece
 */
class History extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'history';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['workpiece_id'], 'required'],
            [['workpiece_id', 'quantity'], 'integer'],
            [['created_at'], 'safe'],
            [['remark'], 'string', 'max' => 255],
            [['workpiece_id'], 'exist', 'skipOnError' => true, 'targetClass' => Workpiece::className(), 'targetAttribute' => ['workpiece_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'workpiece_id' => 'Workpiece ID',
            'quantity' => 'Quantity',
            'remark' => 'Remark',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Workpiece]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWorkpiece()
    {
        return $this->hasOne(Workpiece::className(), ['id' => 'workpiece_id']);
    }

}
