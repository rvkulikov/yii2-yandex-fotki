<?php
namespace romkaChev\yandexFotki\models\query;

use romkaChev\yandexFotki\models\PhotoImage;
use yii\db\ActiveQuery;

/**
 * Class PhotoImageQuery
 *
 * @package romkaChev\yandexFotki\models\query
 *
 * @author  Roman Kulikov <flinnraider@yandex.ru>
 * @since   2.0
 */
class PhotoImageQuery extends ActiveQuery
{
    /**
     * @inheritdoc
     * @return PhotoImage[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return PhotoImage|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}