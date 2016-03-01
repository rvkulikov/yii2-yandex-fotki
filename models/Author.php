<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 17.12.2015
 * Time: 9:19
 */

namespace romkaChev\yandexFotki\models;

use romkaChev\yandexFotki\interfaces\LoadableWithData;
use yii\helpers\ArrayHelper;

/**
 * Class Author
 *
 * @package romkaChev\yandexFotki\models
 */
class Author extends AbstractModel implements LoadableWithData
{
    /** @var string */
    public $name;
    /** @var int */
    public $uid;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['name', 'string'],
            ['uid', 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function loadWithData($data, $fast = false)
    {
        $attributes = [
            'name' => ArrayHelper::getValue($data, 'name'),
            'uid'  => ArrayHelper::getValue($data, $this->getUidParser()),
        ];

        if ($fast) {
            \Yii::configure($this, $attributes);
        } else {
            $this->load([$this->formName() => $attributes]);
        }

        return $this;
    }

    /**
     * @return \Closure
     */
    public function getUidParser()
    {

        /**
         * @param $array
         * @param $defaultValue
         *
         * @return mixed
         */
        return function ($array, $defaultValue) {
            return intval(ArrayHelper::getValue($array, 'uid')) ?: $defaultValue;
        };
    }
}