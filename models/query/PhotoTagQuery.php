<?php
namespace romkaChev\yandexFotki\models\query;

use romkaChev\yandexFotki\models\PhotoTag;
use yii\db\ActiveQuery;

/**
 * Class PhotoTagQuery
 *
 * @package romkaChev\yandexFotki\models\query
 *
 * @author  Roman Kulikov <flinnraider@yandex.ru>
 * @since   2.0
 */
class PhotoTagQuery extends ActiveQuery
{
    /**
     * @inheritdoc
     * @return PhotoTag[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return PhotoTag|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}