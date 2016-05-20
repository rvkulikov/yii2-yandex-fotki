<?php


namespace romkaChev\yandexFotki\models\query;


use romkaChev\yandexFotki\models\Photo;
use yii\db\ActiveQuery;

/**
 * Class PhotoQuery
 *
 * @package romkaChev\yandexFotki\models\query
 *
 * @author  Roman Kulikov <flinnraider@yandex.ru>
 * @since   2.0
 */
class PhotoQuery extends ActiveQuery
{
    /**
     * @inheritdoc
     * @return Photo[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Photo|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}