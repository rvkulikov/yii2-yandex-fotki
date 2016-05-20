<?php
namespace romkaChev\yandexFotki\models\query;


use romkaChev\yandexFotki\models\ImageSize;
use yii\db\ActiveQuery;

/**
 * Class ImageSizeQuery
 *
 * @package romkaChev\yandexFotki\models\query
 *
 * @author  Roman Kulikov <flinnraider@yandex.ru>
 * @since   2.0
 */
class ImageSizeQuery extends ActiveQuery
{
    /**
     * @inheritdoc
     * @return ImageSize[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ImageSize|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}