<?php
namespace romkaChev\yandexFotki\models;


use romkaChev\yandexFotki\models\query\ImageQuery;
use yii\db\ActiveRecord;

/**
 * Class Image
 *
 * @package romkaChev\yandexFotki\models
 *
 * @property-read string    $id
 * @property-read string    $sizeId
 * @property-read integer   $width
 * @property-read integer   $height
 * @property-read integer   $byteSize
 * @property-read string    $href
 *
 * @property-read ImageSize $size
 *
 * @author  Roman Kulikov <flinnraider@yandex.ru>
 * @since   2.0
 */
class Image extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yandex_fotki__image';
    }

    /**
     * @inheritdoc
     * @return ImageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ImageQuery(get_called_class());
    }

    /**
     * @inheritDoc
     * @return Image|null ActiveRecord instance matching the condition, or `null` if nothing matches.
     */
    public static function findOne($condition)
    {
        return parent::findOne($condition);
    }

    /**
     * @inheritDoc
     * @return Image[] an array of ActiveRecord instances, or an empty array if nothing matches.
     */
    public static function findAll($condition)
    {
        return parent::findAll($condition);
    }
}