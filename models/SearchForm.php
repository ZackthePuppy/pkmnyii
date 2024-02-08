<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\httpclient\Client;
/**
 * ContactForm is the model behind the contact form.
 */
class SearchForm extends Model{
    public $pkmn;

    public function rules ()
    {
        return 
        [
            [['pkmn'], 'required']
        ];
    }

    public function attributeLabels()
    {
        return
        [
            'pkmn' => 'Name'
        ];
    }

    public function searchpkmn()
    {
        if ($this -> validate())
        {
            $client = new Client();
            // Send a GET request to the external API
            $response = $client->createRequest()
                ->setMethod('GET')
                ->setUrl('https://pokeapi.co/api/v2/pokemon/' . $this->pkmn) // Replace this URL with the URL of the external API
                ->send();
    
            // Check if the request was successful (status code 200)
            if ($response->isOk) {
                // Decode the JSON response into an associative array
                $data = $response->data;
                // Render a view and pass the API data to it
                return $data;
            } else {
                // Handle the case where the API request failed
                // Yii::error('API request failed: ' . $response->content);
                return false;
            }
        }

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
