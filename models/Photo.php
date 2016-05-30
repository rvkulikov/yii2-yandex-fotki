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
 * @property-read integer     $id
 * @property integer          $authorId
 * @property integer          $albumId
 * @property string           $accessId
 * @property string           $title
 * @property string           $summary
 * @property boolean          $isAdultsOnly
 * @property boolean          $isOriginalHidden
 * @property boolean          $isCommentsDisabled
 * @property float            $latitude
 * @property float            $longitude
 * @property-read DateTime    $publishedAt
 * @property-read DateTime    $updatedAt
 * @property-read DateTime    $editedAt
 *
 * @property-read string      $urn
 * @property-read PhotoAccess $access
 * @property-read Author      $author
 * @property-read Image[]     $images
 * @property-read Album       $album
 * @property-read Tag[]       $tags
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

    /**
     * @return string
     */
    public function getUrn()
    {
        return "urn:yandex:fotki:{$this->author->name}:photo:{$this->id}";
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccess()
    {
        return $this->hasOne(PhotoAccess::className(), ['id' => 'accessId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(Author::className(), ['id' => 'authorId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImages()
    {
        return $this->hasMany(Image::className(), ['photoId' => 'id']);
    }

    public function getAlbum()
    {
        return $this->hasOne(Album::className(), ['id' => 'albumId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPhotoTags()
    {
        return $this->hasMany(PhotoTag::className(), ['photoId' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['id' => 'tagId'])->via('photoTags');
    }
}