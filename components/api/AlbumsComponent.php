<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 02.06.2016
 * Time: 0:05
 */

namespace romkaChev\yandexFotki\components\api;


use romkaChev\yandexFotki\formatters\JsonFormatter;
use romkaChev\yandexFotki\models\Album;
use yii\base\Component;
use yii\httpclient\Client;

/**
 * Class AlbumsComponent
 *
 * @package romkaChev\yandexFotki\components\api
 */
class AlbumsComponent extends Component
{
    /** @var string */
    private $apiBaseUrl = 'http://api-fotki.yandex.ru/api';

    /**
     * @param Album $album
     *
     * @return array|mixed
     */
    public function create(Album $album)
    {
        $httpClient = $this->createHttpClient($album->login, $album->oauthToken);

        $request = $httpClient->post("albums/", [
            'title'   => $album->title,
            'summary' => $album->summary,
            'links'   => [
                'album' => "{$httpClient->baseUrl}/album/{$album->parentId}/"
            ]
        ]);

        $response = $request->send();

        return $response->getData();
    }

    /**
     * @param Album $album
     *
     * @return array|mixed
     */
    public function update(Album $album)
    {
        $httpClient = $this->createHttpClient($album->login, $album->oauthToken);

        $request = $httpClient->put("albums/{$album->id}", [
            'title'   => $album->title,
            'summary' => $album->summary,
            'links'   => [
                'album' => "{$httpClient->baseUrl}/album/{$album->parentId}/"
            ]
        ]);

        $response = $request->send();

        return $response->getData();
    }

    /**
     * @param Album $album
     *
     * @return array|mixed
     */
    public function delete(Album $album)
    {
        $httpClient = $this->createHttpClient($album->login, $album->oauthToken);
        $request    = $httpClient->delete("albums/{$album->id}");
        $response   = $request->send();

        return $response->getData();
    }

    /**
     * @param string $login
     * @param string $oauthToken
     *
     * @return Client
     * @throws \yii\base\InvalidConfigException
     */
    protected function createHttpClient($login, $oauthToken)
    {
        /** @var Client $httpClient */
        $httpClient                 = \Yii::createObject(Client::className());
        $httpClient->baseUrl        = "{$this->apiBaseUrl}/users/{$login}";
        $httpClient->requestConfig  = [
            'headers' => [
                'Accept'        => 'application/json',
                'Authorization' => "OAuth {$oauthToken}",
            ],
            'format'  => Client::FORMAT_JSON,
        ];
        $httpClient->responseConfig = [
            'format' => Client::FORMAT_JSON,
        ];
        $httpClient->formatters     = [
            Client::FORMAT_JSON => JsonFormatter::className()
        ];

        return $httpClient;
    }
}