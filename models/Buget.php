<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "buget".
 *
 * @property int $id
 * @property int $created_at
 * @property BugetDetailes[] $detailes
 */
class Buget extends \yii\db\ActiveRecord
{
    public $start_row = null;
    public $end_row = null;
    public $start_col = null;
    public $end_col = null;
    
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'buget';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Created At',
        ];
    }

    public function getDetailes(){
        return $this->hasMany(BugetDetailes::className(), ['buget_id' => 'id']);
    }

    public function search(){
        $query = Buget::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);
        return $dataProvider;
    }

    /**
     * @return BugetDetailes
     */
    public function getDetailsByColRow($col, $row){
        return $this->getDetailes()->where(['row' => $row, 'col' => chr($col)])->one();
    }
    
    public function afterFind()
    {
        parent::afterFind();
        foreach ($this->detailes as $detail){
            if(!$this->start_row){
                $this->start_row = $detail->row;
            } elseif($detail->row < $this->start_row){
                $this->start_row = $detail->row; 
            }
            if(!$this->end_row){
                $this->end_row = $detail->row;
            } elseif($detail->row > $this->end_row){
                $this->end_row = $detail->row;
            }
            if(!$this->start_col){
                $this->start_col = ord($detail->col);
            } elseif(ord($detail->col) < $this->start_col){
                $this->start_col = ord($detail->col);
            }
            if(!$this->end_col){
                $this->end_col = ord($detail->col);
            } elseif(ord($detail->col) > $this->end_col){
                $this->end_col = ord($detail->col);
            }
        }
    }

}
