<?php


namespace romkaChev\yandexFotki\models\query;


use romkaChev\yandexFotki\models\Tag;
use yii\db\ActiveQuery;

/**
 * Class TagQuery
 *
 * @package romkaChev\yandexFotki\models\query
 *
 * @author  Roman Kulikov <flinnraider@yandex.ru>
 * @since   2.0
 */
class TagQuery extends ActiveQuery
{
    /**
     * @inheritdoc
     * @return Tag[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Tag|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}