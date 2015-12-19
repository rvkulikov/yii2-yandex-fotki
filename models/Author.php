<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 18.12.2015
 * Time: 22:34
 */

namespace romkaChev\yandexFotki\models;


use romkaChev\yandexFotki\interfaces\models\IAuthor;
use romkaChev\yandexFotki\traits\ModuleAccess;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class Author extends Model implements IAuthor
{
    use ModuleAccess;

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
            [['name'], 'required'],
        ];
    }

    /**
     * @param array $data
     *
     * @return static
     */
    public function loadWithData($data)
    {
        $this->load([
            $this->formName() => [
                'name' => ArrayHelper::getValue($data, 'name'),
                'uid'  => ArrayHelper::getValue($data, $this->getUidParser()),
            ],
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