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


    class TaskattachmentController extends ActiveController
    {
        public $modelClass = 'common\models\TaskAttachment';

        public function actionUpload()
        {
            foreach ($_FILES as $file) {
                $fileName = mt_rand( 0, PHP_INT_MAX ) . "_" . $file['name'];
                $fileUrl  = "/web/uploads/" . $_REQUEST['task_id'] . "/";
                $filePath = Yii::getAlias( Yii::$app->params['filePath'] ) . $fileUrl . $fileName;
                if ( ! is_dir( Yii::getAlias( Yii::$app->params['filePath'] ) . $fileUrl )) {
                    mkdir( Yii::getAlias( Yii::$app->params['filePath'] ) . $fileUrl, 0777, true );
                }
                move_uploaded_file( $file['tmp_name'], $filePath );
                $model          = new TaskAttachment();
                $model->name    = $file['name'];
                $model->task_id = $_REQUEST['task_id'];
                $model->path    = $fileName;
                $response       = Yii::$app->getResponse();
                if ($model->save()) {
                    $response->setStatusCode( 200 );
                }
                $model->path       = Yii::$app->params['domainName'] . "/uploads/" . $model->task_id . "/" . $fileName;
                $response->content = json_encode( $model->attributes );
                $response->send();
                Yii::$app->end();

            }

        }
        public function actionSearch($task_id){
            return TaskAttachment::findAll(['task_id'=>$task_id]);
        }
    }