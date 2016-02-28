<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 17.12.2015
 * Time: 9:47
 */

namespace romkaChev\yandexFotki\interfaces\models;

use romkaChev\yandexFotki\interfaces\LoadableWithData;
use romkaChev\yandexFotki\traits\parsers\PointParser;
use yii\helpers\ArrayHelper;

/**
 * Class AbstractAddressBinding
 *
 * @package romkaChev\yandexFotki\interfaces\models
 */
abstract class AbstractAddressBinding extends AbstractModel implements LoadableWithData
{

    use PointParser;

    /** @var int */
    public $organizationId;
    /** @var string */
    public $address;
    /** @var AbstractPoint */
    public $point;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //@formatter:off
            ['organizationId', 'integer'],
            ['address', 'string'],
            ['point', $this->getYandexFotki()->getFactory()->getPointValidator()],
            //@formatter:on
        ];
    }

    /**
     * @inheritdoc
     */
    public function loadWithData($data, $fast = false)
    {
        $factory    = $this->getYandexFotki()->getFactory();
        $attributes = [
            'organizationId' => ArrayHelper::getValue($data, 'organizationId'),
            'address'        => ArrayHelper::getValue($data, 'address'),
            'point'          => ArrayHelper::getValue($data, $this->getPointParser('geo', $factory->getPointModel(), $fast)),
        ];

        if ($fast) {
            \Yii::configure($this, $attributes);
        } else {
            $this->load([$this->formName() => $attributes]);
        }

        return $this;
    }
}