<?php
namespace romkaChev\yandexFotki\models;


use DateTime;
use romkaChev\yandexFotki\models\query\PhotoQuery;
use yii\db\ActiveRecord;

/**
 * Class Photo
 *
 * @package romkaChev\yandexFotki\models
 *
 * @property-read string   $urn
 * @property-read integer  $id
 * @property-read DateTime $publishedAt
 * @property-read DateTime $updatedAte
 * @property-read DateTime $editedAt
 *
 * @property integer       $albumId
 * @property string        $title
 * @property string        $summary
 * @property string        $access
 * @property boolean       $isAdultsOnly
 * @property boolean       $isOriginalHidden
 * @property boolean       $isCommentsDisabled
 * @property float         $latitude
 * @property float         $longitude
 *
 * @property-read Author   $author
 * @property-read Image[]  $images
 * @property-read Album    $album
 * @property-read Tag[]    $tags
 *
 * @author  Roman Kulikov <flinnraider@yandex.ru>
 * @since   2.0
 */
class Photo extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yandex_fotki__photo';
    }

    /**
     * @inheritdoc
     * @return PhotoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PhotoQuery(get_called_class());
    }

    /**
     * @inheritDoc
     * @return Photo|null ActiveRecord instance matching the condition, or `null` if nothing matches.
     */
    public static function findOne($condition)
    {
        return parent::findOne($condition);
    }

    /**
     * @inheritDoc
     * @return Photo[] an array of ActiveRecord instances, or an empty array if nothing matches.
     */
    public static function findAll($condition)
    {
        return parent::findAll($condition);
    }
}