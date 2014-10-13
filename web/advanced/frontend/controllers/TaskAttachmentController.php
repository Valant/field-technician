<?php
	/**
	 * Created by PhpStorm.
	 * User: godson
	 * Date: 06.10.14
	 * Time: 13:44
	 */

	namespace frontend\controllers;

	use Yii;
	use common\models\TaskAttachment;
	use yii\rest\ActiveController;



	class TaskAttachmentController extends ActiveController
	{
		public $modelClass = 'common\models\TaskAttachment';

		public function actionUpload()
		{
			foreach ($_FILES as $file) {
				$filePath = "/tmp/" . mt_rand( 0, PHP_INT_MAX ) . "_" . $file['name'];
				move_uploaded_file( $file['tmp_name'], $filePath );
				$model          = new TaskAttachment();
				$model->name    = $file['name'];
				$model->task_id = $_REQUEST['task_id'];
				$model->path    = $filePath;
				$response       = Yii::$app->getResponse();
				if ($model->save()) {
					$response->setStatusCode( 200 );
				}
				$response->content = json_encode( $model->attributes );
				$response->send();
				Yii::$app->end();

			}

		}
	}