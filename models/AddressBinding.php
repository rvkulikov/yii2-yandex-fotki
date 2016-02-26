<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 18.12.2015
 * Time: 22:42
 */

namespace romkaChev\yandexFotki\models;


use romkaChev\yandexFotki\interfaces\models\IAddressBinding;
use romkaChev\yandexFotki\traits\parsers\PointParser;
use romkaChev\yandexFotki\traits\YandexFotkiAccess;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class AddressBinding extends Model implements IAddressBinding
{
    use YandexFotkiAccess, PointParser;

    /** @var int */
    public $organizationId;
    /** @var string */
    public $address;
    /** @var Point */
    public $point;

    public function rules()
    {
        return [
            ['organizationId', 'integer'],
            ['address', 'string'],
            ['point', $this->yandexFotki->pointValidator],
        ];
    }

    /**
     * @param $data
     *
     * @return $this
     */
    public function loadWithData($data)
    {
        \Yii::configure($this, [
            'organizationId' => ArrayHelper::getValue($data, 'organizationId'),
            'address'        => ArrayHelper::getValue($data, 'address'),
            'point'          => ArrayHelper::getValue($data, $this->getPointParser($this->yandexFotki->pointModel)),
        ]);

        return $this;
    }
}