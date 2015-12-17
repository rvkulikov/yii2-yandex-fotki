<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 17.12.2015
 * Time: 8:57
 */

namespace romkaChev\yandexFotki\interfaces\components;


use romkaChev\yandexFotki\interfaces\models\ITag;

interface ITagComponent extends ICrudComponent
{

    /**
     * @param int|string|int[]|string[] $identity
     *
     * @return ITag|ITag[]
     */
    public function get($identity);

    /**
     * @param mixed $data
     *
     * @return ITag|ITag[]
     */
    public function create($data);

    /**
     * @param mixed $data
     *
     * @return ITag|ITag[]
     */
    public function update($data);

    /**
     * @param mixed $data
     *
     * @return ITag|ITag[]
     */
    public function delete($data);
}