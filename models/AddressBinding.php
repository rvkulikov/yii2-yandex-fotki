<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 18.12.2015
 * Time: 22:42
 */

namespace romkaChev\yandexFotki\models;


use romkaChev\yandexFotki\interfaces\models\IAddressBinding;
use romkaChev\yandexFotki\traits\YandexFotkiAccess;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class AddressBinding extends Model implements IAddressBinding
{
    use YandexFotkiAccess;

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


    public function loadWithData($data)
    {
        $point = $this->yandexFotki->createPointModel();
        $point->loadWithData(ArrayHelper::getValue($data, 'geo'));

        $this->load([
            $this->formName() => [
                'organizationId' => ArrayHelper::getValue($data, 'organizationId'),
                'address'        => ArrayHelper::getValue($data, 'address'),
                'point'          => $point,
            ],
        ]);

        return $this;
    }

}