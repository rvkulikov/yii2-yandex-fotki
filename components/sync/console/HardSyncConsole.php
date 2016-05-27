<?php
namespace romkaChev\yandexFotki\components\sync\console;

use romkaChev\yandexFotki\components\sync\HardSync;
use romkaChev\yandexFotki\models\Album;
use yii\helpers\ArrayHelper;
use yii\helpers\Console;

/**
 * Class HardSyncConsole
 *
 * @package romkaChev\yandexFotki\components\sync\console
 *
 * @author  Roman Kulikov <flinnraider@yandex.ru>
 */
class HardSyncConsole extends HardSync
{

    private $_albumsDone     = 0;
    private $_albumsTotal    = 0;
    private $_albumsTotalWas = 0;

    private $_photosDone  = 0;
    private $_photosTotal = 0;

    public function sync()
    {
        $this->_albumsTotalWas = Album::find()->count('id') ?: 0;

        parent::sync();
    }


    /**
     * @inheritdoc
     */
    protected function syncAlbums()
    {
        Console::startProgress(0, $this->_albumsTotalWas, 'Sync albums', 80);

        $httpClient = $this->httpClient;
        $request    = $httpClient->get("albums/rupdated/", ['format' => 'json', 'limit' => $this->perPage]);

        do {
            $data      = $this->processRequest($request);
            $rawAlbums = ArrayHelper::getValue($data, 'entries', []);

            $this->processAlbumsBatch($rawAlbums);

            $linkNext = ArrayHelper::getValue($data, 'links.next');
            $request  = $httpClient->get($linkNext);

            $this->_albumsDone += count($rawAlbums);

            if ($this->_albumsDone > $this->_albumsTotalWas) {
                $this->_albumsTotal = $this->_albumsDone;
                if ($linkNext) {
                    $this->_albumsTotal += 100;
                }
            } else {
                $this->_albumsTotal = $this->_albumsTotalWas;
            }

            Console::updateProgress($this->_albumsDone, $this->_albumsTotal);

        } while ($linkNext);

        Console::endProgress();
    }

    /**
     * @inheritdoc
     */
    protected function syncPhotos()
    {
        Console::startProgress(0, 100, 'Sync photos', 80);

        $httpClient = $this->httpClient;
        $request    = $httpClient->get("photos/rupdated/", ['format' => 'json', 'limit' => $this->perPage]);

        $photosTotal = Album::find()->sum('imageCount');

        do {
            $data      = $this->processRequest($request);
            $rawPhotos = ArrayHelper::getValue($data, 'entries', []);

            $this->processPhotosBatch($rawPhotos);

            $linkNext = ArrayHelper::getValue($data, 'links.next');
            $request  = $httpClient->get($linkNext);

            $this->_photosDone += count($rawPhotos);

            if ($this->_photosDone > $photosTotal) {
                $this->_photosTotal = $this->_photosDone;
                if ($linkNext) {
                    $this->_photosTotal += 100;
                }
            } else {
                $this->_photosTotal = $photosTotal;
            }

            Console::updateProgress($this->_photosDone, $this->_photosTotal);
        } while ($linkNext);

        Console::endProgress();
    }
}