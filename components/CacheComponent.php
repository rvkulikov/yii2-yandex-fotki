<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 04.03.2016
 * Time: 23:10
 */

namespace romkaChev\yandexFotki\components;


use romkaChev\yandexFotki\traits\YandexFotkiAccess;
use yii\base\Component;
use yii\caching\Cache;

/**
 * Class CacheComponent
 *
 * @package romkaChev\yandexFotki\components
 */
class CacheComponent extends Component
{
    use YandexFotkiAccess;

    /** @var Cache */
    public $driver;

    public $serviceKey = 'urn:yandex:fotki:{login}:_service';

    public $photoKey = 'urn:yandex:fotki:{login}:album:{id}';
    public $albumKey = 'urn:yandex:fotki:{login}:photo:{id}';
    public $tagKey   = 'urn:yandex:fotki:{login}:tag:{id}';

    public $albumsCollectionKey = 'urn:yandex:fotki:{login}:albums';
    public $photosCollectionKey = 'urn:yandex:fotki:{login}:photos';
    public $tagsCollectionKey   = 'urn:yandex:fotki:{login}:tags';

    public $albumPhotosCollectionKey = 'urn:yandex:fotki:{login}:album:{id}:photos';
    public $tagPhotosCollectionKey   = 'urn:yandex:fotki:{login}:tag:{id}:photos';

    public function get($id)
    {

    }
}