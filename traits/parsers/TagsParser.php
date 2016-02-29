<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 28.02.2016
 * Time: 14:15
 */

namespace romkaChev\yandexFotki\traits\parsers;


use romkaChev\yandexFotki\models\Tag;
use yii\helpers\ArrayHelper;

trait TagsParser
{
    /**
     * @param string|\Closure|array $key
     * @param Tag                   $model
     * @param bool                  $fast
     *
     * @return \Closure
     */
    public function getTagsParser($key, Tag $model, $fast = false)
    {
        /**
         * @param $array
         *
         * @return \romkaChev\yandexFotki\models\Tag[]
         */
        return function ($array) use ($key, $model, $fast) {
            $login   = $model->getYandexFotki()->getLogin();
            $entries = ArrayHelper::getValue($array, $key, []);
            $models  = [];

            foreach ($entries as $id => $linkSelf) {
                $localModel     = clone $model;
                $localModel->id = mb_strtolower($id);

                $localModel->loadWithData([
                    'id'      => "urn:yandex:fotki:{$login}:tag:{$id}",
                    'urn'     => $localModel->defaultUrn(),
                    'title'   => $localModel->defaultTitle(),
                    'authors' => $localModel->defaultAuthors(),
                    'links'   => [
                        'self'      => $localModel->defaultLinkSelf(),
                        'edit'      => $localModel->defaultLinkEdit(),
                        'photos'    => $localModel->defaultLinkPhotos(),
                        'alternate' => $localModel->defaultLinkAlternate(),
                    ]
                ], $fast);

                $models[] = $localModel;
            }

            return ArrayHelper::index($models, 'id');
        };
    }
}