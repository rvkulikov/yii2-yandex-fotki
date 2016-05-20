<?php
namespace romkaChev\yandexFotki\models;

use romkaChev\yandexFotki\models\query\ImageSizeQuery;
use yii\db\ActiveRecord;

/**
 * Interface ImageSizeInterface
 *
 * @package romkaChev\yandexFotki\models
 *
 * @property-read integer $id
 *
 * @author  Roman Kulikov <flinnraider@yandex.ru>
 * @since   2.0
 */
class ImageSize extends ActiveRecord
{
    const SIZE_XXXS     = 'XXXS';
    const SIZE_XXS      = 'XXS';
    const SIZE_XS       = 'XS';
    const SIZE_S        = 'S';
    const SIZE_M        = 'M';
    const SIZE_L        = 'L';
    const SIZE_XL       = 'XL';
    const SIZE_XXL      = 'XXL';
    const SIZE_XXXL     = 'XXXL';
    const SIZE_X4L      = 'X4L';
    const SIZE_X5L      = 'X5L';
    const SIZE_ORIGINAL = 'orig';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yandex_fotki__image_size';
    }

    /**
     * @inheritdoc
     * @return ImageSizeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ImageSizeQuery(get_called_class());
    }

    /**
     * @inheritDoc
     * @return ImageSize|null ActiveRecord instance matching the condition, or `null` if nothing matches.
     */
    public static function findOne($condition)
    {
        return parent::findOne($condition);
    }

    /**
     * @inheritDoc
     * @return ImageSize[] an array of ActiveRecord instances, or an empty array if nothing matches.
     */
    public static function findAll($condition)
    {
        return parent::findAll($condition);
    }
}