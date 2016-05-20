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

}