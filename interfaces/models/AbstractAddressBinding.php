<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 17.12.2015
 * Time: 9:47
 */

namespace romkaChev\yandexFotki\interfaces\models;

use romkaChev\yandexFotki\traits\parsers\PointParser;
use yii\helpers\ArrayHelper;

/**
 * Interface IPhotoAddressBinding
 *
 * @package romkaChev\yandexFotki\interfaces\models
 *
 * @property integer       organizationId
 * @property string        address
 * @property AbstractPoint point
 */
abstract class AbstractAddressBinding extends AbstractModel
{

    use PointParser;

    /**
     * @param array $data
     *
     * @return static
     */
    public function loadWithData($data)
    {
        \Yii::configure($this, [
            'organizationId' => ArrayHelper::getValue($data, 'organizationId'),
            'address'        => ArrayHelper::getValue($data, 'address'),
            'point'          => ArrayHelper::getValue($data, $this->getPointParser($this->getYandexFotki()->getFactory()->getPointModel())),
        ]);

        return $this;
    }

    /**
     * @return int
     */
    public function getOrganizationId()
    {
        return $this->organizationId;
    }

    /**
     * @param int $organizationId
     */
    public function setOrganizationId($organizationId)
    {
        $this->organizationId = $organizationId;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return AbstractPoint
     */
    public function getPoint()
    {
        return $this->point;
    }

    /**
     * @param AbstractPoint $point
     */
    public function setPoint($point)
    {
        $this->point = $point;
    }
}