<?php
/**
 * @var $this \yii\web\View
 * @var $dataProvider \yii\data\ActiveDataProvider
 */

use yii\grid\GridView;
?>
<?php echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'id',
        'created_at',
        [
            'class' => \yii\grid\ActionColumn::className(),
            'template' => '{view}'
        ]
    ]
]);
