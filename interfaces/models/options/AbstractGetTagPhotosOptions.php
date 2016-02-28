<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 28.02.2016
 * Time: 19:47
 */

namespace romkaChev\yandexFotki\interfaces\models\options;


use romkaChev\yandexFotki\interfaces\models\AbstractModel;
use romkaChev\yandexFotki\interfaces\models\IFeedAdapter;
use yii\base\InvalidConfigException;
use yii\helpers\VarDumper;

/**
 * Class AbstractGetTagPhotosOptions
 *
 * @package romkaChev\yandexFotki\interfaces\models\options
 *
 * @property-read string $sort
 */
class AbstractGetTagPhotosOptions extends AbstractModel implements IFeedAdapter
{

    /** @var int */
    public $limit;
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
            ['limit', 'default', 'value' => static::LIMIT_MAX],
            ['limit', 'integer', 'min' => 1, 'max' => static::LIMIT_MAX],

            ['sortType', 'default', 'value' => static::SORT_UPDATED],
            ['sortType', 'in', 'range' => [static::SORT_UPDATED, static::SORT_PUBLISHED, static::SORT_CREATED, static::SORT_MANUAL], 'strict' => true],

            ['sortDirection', 'default', 'value' => SORT_DESC],
            ['sortDirection', 'in', 'range' => [SORT_ASC, SORT_DESC], 'strict' => true],
        ];
    }

    /**
     * @inheritdoc
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
     * @inheritdoc
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