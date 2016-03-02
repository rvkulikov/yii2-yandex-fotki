<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 29.02.2016
 * Time: 22:18
 */

namespace romkaChev\yandexFotki\models\options;


use romkaChev\yandexFotki\interfaces\models\IFeedAdapter;
use romkaChev\yandexFotki\models\AbstractModel;

/**
 * Class PaginationOptions
 *
 * @package romkaChev\yandexFotki\models\options
 *
 * @property-read string $sort
 */
class PaginationOptions extends AbstractModel implements IFeedAdapter
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
     * @return static
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

        return $model;
    }

}