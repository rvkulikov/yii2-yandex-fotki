<?php
namespace romkaChev\yandexFotki\models\query;

use romkaChev\yandexFotki\models\PhotoAccess;
use yii\db\ActiveQuery;

/**
 * Class PhotoAccessQuery
 *
 * @package romkaChev\yandexFotki\models\query
 *
 * @author  Roman Kulikov <flinnraider@yandex.ru>
 * @since   2.0
 */
class PhotoAccessQuery extends ActiveQuery
{
    /**
     * @inheritdoc
     * @return PhotoAccess[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return PhotoAccess|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}