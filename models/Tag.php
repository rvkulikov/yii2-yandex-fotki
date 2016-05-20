<?php
namespace romkaChev\yandexFotki\models;


use DateTime;
use yii\db\ActiveRecord;

/**
 * Class Tag
 *
 * @package romkaChev\yandexFotki\models
 *
 * @property-read string   $urn
 * @property-read integer  $title
 * @property-read DateTime $updatedAt
 *
 *
 * @property-read Author   $author
 * @property-read Photo[]  $photos
 *
 * @author  Roman Kulikov <flinnraider@yandex.ru>
 * @since   2.0
 */
class Tag extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yandex_fotki__tag';
    }

    /**
     * @inheritDoc
     * @return Tag|null ActiveRecord instance matching the condition, or `null` if nothing matches.
     */
    public static function findOne($condition)
    {
        return parent::findOne($condition);
    }

    /**
     * @inheritDoc
     * @return Tag[] an array of ActiveRecord instances, or an empty array if nothing matches.
     */
    public static function findAll($condition)
    {
        return parent::findAll($condition);
    }
}