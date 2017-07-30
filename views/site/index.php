<?php

/* @var $this yii\web\View */
/* @var $form ActiveForm */
/* @var $model ImportForm */


use yii\widgets\ActiveForm;
use app\models\ImportForm;
use yii\helpers\Html;

$this->title = 'My Yii Application';

?>
<div class="site-index">
<?php $form = ActiveForm::begin([
        'method' => 'post',
        'options' => [
                'encription' => 'enctype/form-data'
        ]
]) ?>
<?= $form->field($model, 'file')->fileInput() ?>
<?= Html::submitInput('Upload') // good idea - world "upload" use with Yii::t('app', 'Upload') ?>
<?php ActiveForm::end() ?>
</div>
