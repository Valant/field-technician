<?php
    /**
     * Created by PhpStorm.
     * User: godson
     * Date: 17.11.14
     * Time: 10:57
     */

    namespace frontend\controllers;

    use common\models\TaskAttachment;
    use Yii;
    use yii\filters\auth\QueryParamAuth;
    use yii\rest\ActiveController;
    use common\models\LoginForm;




    class UserController extends ActiveController
    {
        public $modelClass = 'common\models\User';

        public function actionLogin()
        {

            $model = new LoginForm();
            if ($model->load( Yii::$app->request->post() ) && $model->login()) {
                return $model->getUser();

            } else {
                return [ 'status' => 'error', 'message' => $model->getErrors() ];
            }
        }

        public function behaviors()
        {
            $behaviors = parent::behaviors();
            $behaviors['authenticator'] = [
                'class' => QueryParamAuth::className(),
                'except'=>['login']
            ];
            return $behaviors;
        }

        public function actionSendreceipt(){
            $postData = Yii::$app->request->post();

            $img = $postData['sign'];
            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $fileData = base64_decode($img);
            $tmpFileName =  tempnam(sys_get_temp_dir(),$postData['task_id']);
            file_put_contents($tmpFileName, $fileData);

            $fileName = mt_rand( 0, PHP_INT_MAX ) . "_userSign" ;
            $fileUrl  = "/web/uploads/" . $postData['task_id'] . "/";
            $filePath = Yii::getAlias( Yii::$app->params['filePath'] ) . $fileUrl . $fileName;
            if ( ! is_dir( Yii::getAlias( Yii::$app->params['filePath'] ) . $fileUrl )) {
                mkdir( Yii::getAlias( Yii::$app->params['filePath'] ) . $fileUrl, 0777, true );
            }
            copy( $tmpFileName, $filePath );
            unlink($tmpFileName);
            $model          = new TaskAttachment();
            $model->name    = 'User sign';
            $model->task_id = $postData['task_id'];
            $model->path    = $fileName;
            $model->save();


            $signUrl = Yii::$app->params['domainName'] . "/uploads/" . $model->task_id . "/" . $fileName;


            $mailBody = "<p>Hi!</p>";
            $mailBody .= "<h3>Timing</h3>";
            $mailBody .= $postData['time'];
            $mailBody .= "<h3>Used parts</h3>";
            $mailBody .= $postData['parts'];

            mail($postData['email'],'Receipt',$mailBody);

            return ['file'=>$signUrl,'body'=>$mailBody];
        }
    }