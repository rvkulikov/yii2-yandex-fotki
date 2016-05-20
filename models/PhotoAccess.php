<?php
namespace romkaChev\yandexFotki\models;

use romkaChev\yandexFotki\models\query\PhotoAccessQuery;
use yii\db\ActiveRecord;

/**
 * Interface PhotoAccessInterface
 *
 * @package romkaChev\yandexFotki\models
 *
 * @property-read integer $id
 *
 * @author  Roman Kulikov <flinnraider@yandex.ru>
 * @since   2.0
 */
class PhotoAccess extends ActiveRecord
{
    const ACCESS_PUBLIC  = 'public';
    const ACCESS_FRIENDS = 'friends';
    const ACCESS_PRIVATE = 'private';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yandex_fotki__photo_access';
    }

    /**
     * @inheritdoc
     * @return PhotoAccessQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PhotoAccessQuery(get_called_class());
    }

    /**
     * @inheritDoc
     * @return PhotoAccess|null ActiveRecord instance matching the condition, or `null` if nothing matches.
     */
    public static function findOne($condition)
    {
        return parent::findOne($condition);
    }

    /**
     * @inheritDoc
     * @return PhotoAccess[] an array of ActiveRecord instances, or an empty array if nothing matches.
     */
    public static function findAll($condition)
    {
        return parent::findAll($condition);
    }
}