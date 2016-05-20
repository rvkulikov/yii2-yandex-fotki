<?php
namespace romkaChev\yandexFotki\models;


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

}