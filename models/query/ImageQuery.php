<?php
namespace romkaChev\yandexFotki\models\query;


use romkaChev\yandexFotki\models\Image;
use yii\db\ActiveQuery;

/**
 * Class ImageQuery
 *
 * @package romkaChev\yandexFotki\models\query
 *
 * @author  Roman Kulikov <flinnraider@yandex.ru>
 * @since   2.0
 */
class ImageQuery extends ActiveQuery
{
    /**
     * @inheritdoc
     * @return Image[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Image|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}