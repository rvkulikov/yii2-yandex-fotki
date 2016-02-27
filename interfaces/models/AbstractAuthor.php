<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 17.12.2015
 * Time: 9:19
 */

namespace romkaChev\yandexFotki\interfaces\models;

use yii\helpers\ArrayHelper;

/**
 * Class AbstractAuthor
 *
 * @package romkaChev\yandexFotki\interfaces\models
 */
abstract class AbstractAuthor extends AbstractModel
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
     * @param array $data
     *
     * @return static
     */
    public function loadWithData($data)
    {
        \Yii::configure($this, [
            'name' => ArrayHelper::getValue($data, 'name'),
            'uid'  => ArrayHelper::getValue($data, $this->getUidParser()),
        ]);

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