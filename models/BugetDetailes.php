<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "buget_detailes".
 *
 * @property int $id
 * @property int $buget_id
 * @property string $col
 * @property int $row
 * @property int $rowspan
 * @property int $colspan
 * @property string $value
 * @property string $fill
 * @property string $color
 * @property string $range
 */
class BugetDetailes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'buget_detailes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['buget_id', 'row', 'colspan', 'rowspan'], 'integer'],
            [['col'], 'string', 'max' => 4],
            [['fill', 'color'], 'string', 'max' => 255],
            [['value', 'range'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'buget_id' => 'Buget ID',
            'col' => 'Col',
            'row' => 'Row',
            'value' => 'Value',
            'fill' => 'Fill',
            'color' => 'Color',
        ];
    }
}
