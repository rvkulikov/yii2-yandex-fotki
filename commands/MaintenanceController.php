<?php
namespace romkaChev\yandexFotki\commands;

use romkaChev\yandexFotki\components\sync\HardSync;
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

    public function actionSync()
    {
        $syncComponent = new HardSync([
            'db'         => $this->module->db,
            'formatter'  => $this->module->formatter,
            'httpClient' => $this->module->httpClient,
        ]);

        $syncComponent->sync();
    }
}