<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\SearchForm;
use yii\httpclient\Client;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }


    /**
     * Displays new page.
     *
     */
    public function actionSearch()
    {
        $model = new SearchForm();

        if ($model->load(Yii::$app->request->post())){
            if (!$model->searchpkmn()) {
                
            Yii::$app->session->setFlash('pkmnNameNotFound');
            return $this->render('search', [
                'model' => $model
            ]);
            }
            else {
                $value = $model->searchpkmn();
                Yii::$app->session->setFlash('pkmnNameSubmitted');
                return $this->render('search', [
                    'data' => $value,
                    'model' => $model
                ]);
            }
        }

        return $this->render('search',[
            'model' => $model,
        ]);
    }



    public function actionNewORIGINAL(){
        // Create a new HTTP client instance
        $client = new Client();
        $pkmn = 'ditto';
        // Send a GET request to the external API
        $response = $client->createRequest()
            ->setMethod('GET')
            ->setUrl('https://pokeapi.co/api/v2/pokemon/' . $pkmn) // Replace this URL with the URL of the external API
            ->send();

        // Check if the request was successful (status code 200)
        if ($response->isOk) {
            // Decode the JSON response into an associative array
            $data = $response->data;
            // Render a view and pass the API data to it
            return $this->render('new', [
                'data' => $data
            ]);
        } else {
            // Handle the case where the API request failed
            Yii::error('API request failed: ' . $response->content);
            throw new \yii\web\HttpException(500, 'API is not found.');
        }
    }

}
