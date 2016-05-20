<?php
namespace romkaChev\yandexFotki\models;


use romkaChev\yandexFotki\models\query\AuthorQuery;
use yii\db\ActiveRecord;

/**
 * Class Author
 *
 * @package romkaChev\yandexFotki\models
 *
 * @property integer $uid
 * @property string  $name
 *
 * @property Album[] $albums
 * @property Photo[] $photos
 *
 * @author  Roman Kulikov <flinnraider@yandex.ru>
 * @since   2.0
 */
class Author extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yandex_fotki__author';
    }

    /**
     * @inheritdoc
     * @return AuthorQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AuthorQuery(get_called_class());
    }

    /**
     * @inheritDoc
     * @return Author|null ActiveRecord instance matching the condition, or `null` if nothing matches.
     */
    public static function findOne($condition)
    {
        return parent::findOne($condition);
    }

    /**
     * @inheritDoc
     * @return Author[] an array of ActiveRecord instances, or an empty array if nothing matches.
     */
    public static function findAll($condition)
    {
        return parent::findAll($condition);
    }
}