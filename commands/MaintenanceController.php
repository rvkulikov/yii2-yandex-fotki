<?php
namespace romkaChev\yandexFotki\commands;

use romkaChev\yandexFotki\components\sync\console\HardSyncConsole;
use romkaChev\yandexFotki\components\sync\HardSync;
use romkaChev\yandexFotki\components\sync\SyncInterface;
use romkaChev\yandexFotki\Module;
use yii\console\Controller;

/**
 * Class MaintenanceController
 *
 * @package romkaChev\yandexFotki\commands
 *
 * @author  Roman Kulikov <flinnraider@yandex.ru>
 * @since   2.0
 */
class MaintenanceController extends Controller
{
    /** @var Module */
    public $module;

    public function getComponentsMap()
    {
        return [
            'hard'         => HardSync::className(),
            'hard-console' => HardSyncConsole::className()
        ];
    }

    public function actionSync($component)
    {
        /** @var SyncInterface $syncComponent */
        $syncComponent = \Yii::createObject([
            'class'      => $this->getComponentsMap()[$component],
            'db'         => $this->module->db,
            'formatter'  => $this->module->formatter,
            'httpClient' => $this->module->httpClient,
        ]);

        $syncComponent->sync();
    }
}