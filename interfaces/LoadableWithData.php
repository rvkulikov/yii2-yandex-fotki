<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 28.02.2016
 * Time: 15:16
 */

namespace romkaChev\yandexFotki\interfaces;


interface LoadableWithData
{
    /**
     * @param array $data
     * @param bool  $fast
     *
     * @return $this
     */
    public function loadWithData($data, $fast = false);
}