<?php

namespace app\controllers;

use app\models\AirportName;
use app\models\Trip;
use app\models\TripService;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\filters\VerbFilter;
use yii\web\Controller;

class SiteController extends Controller
{
	public function behaviors()
	{
		return [
			'verbs' => [
				'class'   => VerbFilter::className(),
				'actions' => [
					'logout' => ['post'],
				],
			],
		];
	}

	public function actions()
	{
		return [
			'error'   => [
				'class' => 'yii\web\ErrorAction',
			],
			'captcha' => [
				'class'           => 'yii\captcha\CaptchaAction',
				'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
			],
		];
	}

	public function actionIndex()
	{
		$airports = AirportName::find()
		                       ->where(['LIKE', 'value', 'Домодедово%', false])
		                       ->all();

		$airport_id = (int)Yii::$app->request->get('airport_id');

		$trip_corporate_id = 3;
		$trip_service_service_id = 2;

		$trips = new ActiveDataProvider([
			'query' => Trip::find()
			               ->joinWith(['tripServices', 'tripServices.flightSegment'])
			               ->where([
				               'corporate_id'            => $trip_corporate_id,
				               'trip_service.service_id' => $trip_service_service_id,
				               'depAirportId'           => $airport_id,
			               ])
		]);

		return $this->render('index', [
			"airports" => $airports,
			"trips"    => $trips,
		]);
	}
}
