<?php

namespace simple\blocks\backend\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\BadRequestHttpException;
use yii\web\Controller;

use simple\blocks\backend\models\GroupForm;
use simple\blocks\common\models\Group;

/**
 * Block groups manage controller
 */
class GroupController extends Controller
{

	/**
	 * Access control
	 * @return array
	 */
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'rules' => [
					['allow' => true, 'roles' => ['Blocks']],
				],
			],
		];
	}

	/**
	 * List
	 * @return void
	 */
	public function actionIndex()
	{
		$dataProvider = new ActiveDataProvider([
			'query' => Group::find(),
		]);

		return $this->render('index', [
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Creating
	 * @return void
	 */
	public function actionCreate()
	{
		$model = new GroupForm;

		if ($model->load(Yii::$app->getRequest()->post()) && $model->create()) {
			Yii::$app->session->setFlash('success', Yii::t('blocks', 'Changes saved successfully.'));
			return $this->redirect(['index']);
		}

		return $this->render('create', [
			'model' => $model,
		]);
	}

	/**
	 * Updating
	 * @param integer $id
	 * @return void
	 */
	public function actionUpdate($id)
	{
		$object = Group::findOne($id);
		if ($object === null)
			throw new BadRequestHttpException(Yii::t('blocks', 'Group not found.'));

		$model = new GroupForm(['object' => $object]);

		if ($model->load(Yii::$app->getRequest()->post()) && $model->update()) {
			Yii::$app->session->setFlash('success', Yii::t('blocks', 'Changes saved successfully.'));
			return $this->redirect(['index']);
		}

		return $this->render('update', [
			'model' => $model,
		]);
	}

	/**
	 * Deleting
	 * @param integer $id
	 * @return void
	 */
	public function actionDelete($id)
	{
		$object = Group::findOne($id);
		if ($object === null)
			throw new BadRequestHttpException(Yii::t('blocks', 'Group not found.'));

		if ($object->delete()) {
			Yii::$app->session->setFlash('success', Yii::t('blocks', 'Group deleted successfully.'));
		}

		return $this->redirect(['index']);
	}

}