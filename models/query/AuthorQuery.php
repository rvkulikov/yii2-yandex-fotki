<?php
namespace romkaChev\yandexFotki\models\query;


use romkaChev\yandexFotki\models\Author;
use yii\db\ActiveQuery;

/**
 * Class AuthorQuery
 *
 * @package romkaChev\yandexFotki\models\query
 *
 * @author  Roman Kulikov <flinnraider@yandex.ru>
 * @since   2.0
 */
class AuthorQuery extends ActiveQuery
{
    /**
     * @inheritdoc
     * @return Author[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Author|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}