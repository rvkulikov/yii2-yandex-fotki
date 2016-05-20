<?php
namespace romkaChev\yandexFotki\models;

use romkaChev\yandexFotki\models\query\PhotoTagQuery;
use yii\db\ActiveRecord;

/**
 * Class PhotoTag
 *
 * @package romkaChev\yandexFotki\models
 *
 * @property integer    $id
 * @property integer    $photoId
 * @property string     $tagId
 *
 * @property-read Photo $photo
 * @property-read Tag   $tag
 *
 * @author  Roman Kulikov <flinnraider@yandex.ru>
 * @since   2.0
 */
class PhotoTag extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yandex_fotki__photo___yandex_fotki__image___pivot';
    }

    /**
     * @inheritdoc
     * @return PhotoTagQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PhotoTagQuery(get_called_class());
    }

    /**
     * @inheritDoc
     * @return PhotoTag|null ActiveRecord instance matching the condition, or `null` if nothing matches.
     */
    public static function findOne($condition)
    {
        return parent::findOne($condition);
    }

    /**
     * @inheritDoc
     * @return PhotoTag[] an array of ActiveRecord instances, or an empty array if nothing matches.
     */
    public static function findAll($condition)
    {
        return parent::findAll($condition);
    }
}