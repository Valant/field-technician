<?php
    /**
     * Created by PhpStorm.
     * User: godson
     * Date: 17.11.14
     * Time: 10:57
     */

    namespace frontend\controllers;

    use common\components\PageLoaderComponent;
    use common\models\TaskAttachment;
    use Yii;
    use yii\base\ErrorException;
    use yii\filters\auth\QueryParamAuth;
    use yii\rest\ActiveController;
    use common\models\LoginForm;
    use yii\web\HttpException;


    class UserController extends ActiveController
    {
        public $modelClass = 'common\models\User';

        public function actionLogin()
        {

            $model = new LoginForm();
            if ($model->load(Yii::$app->request->post()) && $model->login()) {
                return $model->getUser();

            } else {
                return ['status' => 'error', 'message' => $model->getErrors()];
            }
        }

        public function behaviors()
        {
            $behaviors                  = parent::behaviors();
            $behaviors['authenticator'] = [
                'class'  => QueryParamAuth::className(),
                'except' => ['login', 'sendreceipt']
            ];
            return $behaviors;
        }

        public function actionSendreceipt()
        {
            $postData = Yii::$app->request->post();


            $signUrl = false;
            if (isset($postData['sign'])) {
                if (empty($postData['email'])) {
                    throw new HttpException('503', 'No email');
                }
                if (filter_var($postData['email'], FILTER_VALIDATE_EMAIL)) {
                    $img      = $postData['sign'];
                    $img      = str_replace('data:image/png;base64,', '', $img);
                    $img      = str_replace(' ', '+', $img);
                    $fileData = base64_decode($img);

                    $fileName = mt_rand(0, PHP_INT_MAX) . "_userSign";
                    $fileUrl  = "/web/uploads/" . $postData['task_id'] . "/";
                    $filePath = Yii::getAlias(Yii::$app->params['filePath']) . $fileUrl . $fileName;
                    if ( ! is_dir(Yii::getAlias(Yii::$app->params['filePath']) . $fileUrl)) {
                        mkdir(Yii::getAlias(Yii::$app->params['filePath']) . $fileUrl, 0777, true);
                    }
                    file_put_contents($filePath, $fileData);

                    $model          = new TaskAttachment();
                    $model->name    = 'User sign';
                    $model->task_id = $postData['task_id'];
                    $model->path    = $fileName;
                    if (isset($postData['sign_name'])) {
                        $model->sign_name = $postData['sign_name'];
                    }
                    $model->save();

                    PageLoaderComponent::load(
                        \Yii::$app->params['sign.api.url'] . "/serviceworkorders/submit/{$postData['ticket_number']}.json",
                        [
                            "email"         => $postData['email'],
                            "ticket_number" => $postData['ticket_number'],
                            "comments"      => "Comments entered at end of inspection",
                            "customer_name" => $postData['sign_name'],
                            "signature"     => $postData['sign']
                        ],
                        true
                    );

                    $signUrl = Yii::$app->params['domainName'] . "/uploads/" . $model->task_id . "/" . $fileName;
                } else {
                    throw new HttpException('503', 'Not valid email');
                }
            }

            if ($signUrl) {
                return ['file' => $signUrl, 'sign' => $signUrl];
            } else {
                return ['status' => true];
            }

        }
    }