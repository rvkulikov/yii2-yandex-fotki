<?php
namespace romkaChev\yandexFotki\models;


use DateTime;
use romkaChev\yandexFotki\models\query\AlbumQuery;
use yii\db\ActiveRecord;

/**
 * Class Album
 *
 * @package romkaChev\yandexFotki\models
 *
 * @property-read integer  $id
 * @property integer       $parentId
 * @property string        $title
 * @property string        $summary
 * @property-read DateTime $publishedAt
 * @property-read DateTime $updatedAt
 * @property-read DateTime $editedAt
 *
 * @property-read string   $urn
 * @property-read Author   $author
 * @property-read Photo[]  $photos
 * @property-read Album    $parent
 * @property-read Album[]  $children
 *
 * @author  Roman Kulikov <flinnraider@yandex.ru>
 * @since   2.0
 */
class Album extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yandex_fotki__album';
    }

    /**
     * @inheritdoc
     * @return AlbumQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AlbumQuery(get_called_class());
    }

    /**
     * @inheritDoc
     * @return Album|null ActiveRecord instance matching the condition, or `null` if nothing matches.
     */
    public static function findOne($condition)
    {
        return parent::findOne($condition);
    }

    /**
     * @inheritDoc
     * @return Album[] an array of ActiveRecord instances, or an empty array if nothing matches.
     */
    public static function findAll($condition)
    {
        return parent::findAll($condition);
    }
}