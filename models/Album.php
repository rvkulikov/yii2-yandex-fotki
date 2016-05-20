<?php
namespace romkaChev\yandexFotki\models;


use DateTime;
use yii\db\ActiveRecord;

/**
 * Class Album
 *
 * @package romkaChev\yandexFotki\models
 *
 * @property-read string   $urn
 * @property-read integer  $id
 * @property-read DateTime $publishedAt
 * @property-read DateTime $updatedAte
 * @property-read DateTime $editedAt
 * @property integer       $parentId
 * @property string        $title
 * @property string        $summary
 * @property boolean       $isProtected
 *
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

}