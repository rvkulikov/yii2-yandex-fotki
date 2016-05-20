<?php
namespace romkaChev\yandexFotki\models;


use DateTime;
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

}