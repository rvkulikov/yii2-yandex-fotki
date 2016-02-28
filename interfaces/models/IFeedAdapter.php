<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 28.02.2016
 * Time: 19:48
 */

namespace romkaChev\yandexFotki\interfaces\models;


interface IFeedAdapter
{
    const LIMIT_MAX = 100;

    const SORT_UPDATED   = 'updated';
    const SORT_PUBLISHED = 'published';
    const SORT_CREATED   = 'created';
    const SORT_MANUAL    = 'manual';

    /**
     * @return string
     */
    public function getSort();
}