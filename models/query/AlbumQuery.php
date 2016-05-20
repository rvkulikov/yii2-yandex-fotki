<?php
namespace romkaChev\yandexFotki\models\query;


use romkaChev\yandexFotki\models\Album;
use yii\db\ActiveQuery;

/**
 * Class AlbumQuery
 *
 * @package romkaChev\yandexFotki\models\query
 *
 * @author  Roman Kulikov <flinnraider@yandex.ru>
 * @since   2.0
 */
class AlbumQuery extends ActiveQuery
{
    /**
     * @inheritdoc
     * @return Album[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Album|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}