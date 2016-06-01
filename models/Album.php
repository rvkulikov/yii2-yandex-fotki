<?php
namespace romkaChev\yandexFotki\models;


use DateTime;
use romkaChev\yandexFotki\components\api\AlbumsComponent;
use romkaChev\yandexFotki\models\query\AlbumQuery;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * Class Album
 *
 * @package romkaChev\yandexFotki\models
 *
 * @property-read integer    $id
 * @property integer         $authorId
 * @property integer         $parentId
 * @property string          $title
 * @property string          $summary
 * @property string          $imageCount
 * @property-read DateTime   $publishedAt
 * @property-read DateTime   $updatedAt
 * @property-read DateTime   $editedAt
 *
 * @property-read string     $urn
 * @property-read Author     $author
 * @property-read Photo[]    $photos
 * @property-read Album|null $parent
 * @property-read Album[]    $children
 *
 * @author  Roman Kulikov <flinnraider@yandex.ru>
 * @since   2.0
 */
class Album extends ActiveRecord
{
    const SCENARIO_INSERT = 'insert';
    const SCENARIO_UPDATE = 'update';

    /** @var string */
    public $login;
    /** @var string */
    public $oauthToken;

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

    /**
     * @return array
     */
    public function rules()
    {
        return [
            //@formatter:off
            ['login',      'string'],
            ['oauthToken', 'string'],

            'authorId' => ['authorId', 'exists', 'targetClass' => Author::className(), 'targetAttribute' => 'id'],
            'parentId' => ['parentId', 'exists', 'targetClass' =>  Album::className(), 'targetAttribute' => 'id', 'skipOnEmpty' => true],

            'title'   => ['title',   'string', 'min' => 1, 'max' =>  255],
            'summary' => ['summary', 'string',             'max' => 8192],

            'imageCount' => ['imageCount', 'integer'],

            'publishedAt' => ['publishedAt', 'safe'],
            'updatedAt'   => ['updatedAt',   'safe'],
            'editedAt'    => ['editedAt',    'safe'],

            ['login',      'required', 'on' => [self::SCENARIO_INSERT, self::SCENARIO_UPDATE]],
            ['oauthToken', 'required', 'on' => [self::SCENARIO_INSERT, self::SCENARIO_UPDATE]],
            ['authorId',   'required', 'on' => [self::SCENARIO_INSERT                       ]],
            ['title',      'required', 'on' => [self::SCENARIO_INSERT                       ]],
            //@formatter:on
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            /** @var AlbumsComponent $albumsComponent */
            $albumsComponent = \Yii::createObject(AlbumsComponent::className());
            $timeZone        = \Yii::$app->timeZone;

            if ($insert) {
                $rawAlbum = $albumsComponent->create($this);
            } else {
                $rawAlbum = $albumsComponent->update($this);
            }

            $this->publishedAt = (new DateTime(ArrayHelper::getValue($rawAlbum, 'published'), $timeZone))->format('Y-m-d H:i:s');
            $this->updatedAt   = (new DateTime(ArrayHelper::getValue($rawAlbum, 'updated'), $timeZone))->format('Y-m-d H:i:s');
            $this->editedAt    = (new DateTime(ArrayHelper::getValue($rawAlbum, 'edited'), $timeZone))->format('Y-m-d H:i:s');

            return true;
        } else {
            return false;
        }
    }

    /**
     * @inheritdoc
     */
    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            /** @var AlbumsComponent $albumsComponent */
            $albumsComponent = \Yii::createObject(AlbumsComponent::className());

            $albumsComponent->delete($this);

            return true;
        } else {
            return false;
        }
    }

    /**
     * @return string
     */
    public function getUrn()
    {
        return "urn:yandex:fotki:{$this->author->name}:album:{$this->id}";
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
    public function getPhotos()
    {
        return $this->hasMany(Photo::className(), ['albumId' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Album::className(), ['id' => 'parentId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChildren()
    {
        return $this->hasMany(Album::className(), ['parentId' => 'id']);
    }
}