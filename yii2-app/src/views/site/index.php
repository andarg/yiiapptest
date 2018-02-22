<?php
/**
 * @var $this     yii\web\View
 * @var $airports app\models\AirportName[]
 * @var $trips yii\data\ActiveDataProvider
 */

use \yii\widgets\ActiveForm;
use \yii\helpers\ArrayHelper;
use \yii\helpers\Html;

$this->title = Yii::$app->name;
?>
<div class="site-index">
	<h1>Hello world</h1>

	<?
	$form = ActiveForm::begin(['method' => 'get', 'action' => '/']);
	$items = ArrayHelper::map($airports, 'airport_id', 'value');
	$params = [
		'prompt'   => 'Укажите аэропорт',
		'onchange' => 'this.form.submit()',
		'options'  => [Yii::$app->request->get('airport_id') => ['Selected' => true]],
	];

	echo Html::dropDownList('airport_id', 'null', $items, $params);
	ActiveForm::end();
	?>
	<?= \yii\grid\GridView::widget([
		'dataProvider' => $trips,
		'columns'      => [
			['class' => 'yii\grid\SerialColumn'],
			'id',
			'corporate_id',
			[
				'attribute' => 'tripServices.service_id',
				'value'     => function ($model) {
					return implode(',', array_map(function ($e) {
						return $e->service_id;
					}, $model->tripServices));
				},
			],

		],
	]); ?>

</div>
