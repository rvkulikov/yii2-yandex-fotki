<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 26.02.2016
 * Time: 17:37
 */

namespace romkaChev\yandexFotki\models\options;


use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\helpers\VarDumper;

/**
 * Class GetAlbumPhotosOptions
 *
 * @package romkaChev\yandexFotki\models\options
 *
 * @property string $sort
 */
class GetAlbumPhotosOptions extends Model
{
    const LIMIT_MAX = 100;

    const SORT_UPDATED   = 'updated';
    const SORT_PUBLISHED = 'published';
    const SORT_CREATED   = 'created';
    const SORT_MANUAL    = 'manual';

    /** @var int */
    public $limit;
    /** @var string */
    public $password;
    /** @var string */
    public $sortType;
    /** @var string */
    public $sortDirection;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['password', 'string'],

            ['limit', 'default', 'value' => static::LIMIT_MAX],
            ['limit', 'integer', 'min' => 1, 'max' => static::LIMIT_MAX],

            ['sortType', 'default', 'value' => static::SORT_UPDATED],
            ['sortType', 'in', 'range' => [static::SORT_UPDATED, static::SORT_PUBLISHED, static::SORT_CREATED, static::SORT_MANUAL], 'strict' => true],

            ['sortDirection', 'default', 'value' => SORT_DESC],
            ['sortDirection', 'in', 'range' => [SORT_ASC, SORT_DESC], 'strict' => true],
        ];
    }

    /**
     * @return string
     */
    public function getSort()
    {
        if ($this->sortType === static::SORT_MANUAL) {
            return $this->sortType;
        }

        return $this->sortDirection === SORT_ASC
            ? "r{$this->sortType}"
            : $this->sortType;
    }

    /**
     * @return static
     * @throws InvalidConfigException
     */
    public static function createDefault()
    {
        $model = new static();
        $model->load([
            $model->formName() => [
                'limit'         => static::LIMIT_MAX,
                'sortType'      => static::SORT_UPDATED,
                'sortDirection' => SORT_DESC,
            ]
        ]);

        if (!$model->validate()) {
            throw new InvalidConfigException(VarDumper::dumpAsString($model->getErrors()));
        }

        return $model;
    }
}