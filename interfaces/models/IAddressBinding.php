<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 17.12.2015
 * Time: 9:47
 */

namespace romkaChev\yandexFotki\interfaces\models;

use romkaChev\yandexFotki\interfaces\IYandexFotkiAccess;

/**
 * Interface IPhotoAddressBinding
 *
 * @package romkaChev\yandexFotki\interfaces\models
 * @property integer organizationId
 * @property string  address
 * @property IPoint  point
 */
interface IAddressBinding extends IYandexFotkiAccess
{
    const CLASS_NAME = __CLASS__;

    /**
     * @param array $data
     *
     * @return static
     */
    public function loadWithData($data);
}