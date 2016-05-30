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
 * @property-read string    $photoId
 * @property-read string    $sizeId
 * @property-read integer   $width
 * @property-read integer   $height
 * @property-read integer   $byteSize
 * @property-read string    $href
 *
 * @property-read ImageSize $size
 * @property-read Photo     $photo
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

    /**
     * @return array
     */
    public function rules()
    {
        return [
            //@formatter:off
            'photoId' => ['photoId', 'exists', 'targetClass' =>     Photo::className(), 'targetAttribute' => 'id'],
             'sizeId' => [ 'sizeId', 'exists', 'targetClass' => ImageSize::className(), 'targetAttribute' => 'id'],

            'title'   => ['title',   'string', 'max' =>  255],
            'summary' => ['summary', 'string', 'max' => 8192],

            'width'    => ['width',    'integer'],
            'height'   => ['height',   'integer'],
            'byteSize' => ['byteSize', 'integer'],

            'href' => ['url'],
            //@formatter:on
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSize()
    {
        return $this->hasOne(ImageSize::className(), ['id' => 'sizeId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPhoto()
    {
        return $this->hasOne(Photo::className(), ['id' => 'photoId']);
    }
}