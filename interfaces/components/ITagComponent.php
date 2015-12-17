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

    const CLASS_NAME = __CLASS__;

    /**
     * @param int|string|int[]|string[] $identity
     *
     * @return ITag
     */
    public function get($identity);

    /**
     * @param mixed $data
     *
     * @return ITag
     */
    public function create($data);

    /**
     * @param mixed $data
     *
     * @return ITag
     */
    public function update($data);

    /**
     * @param mixed $data
     *
     * @return ITag
     */
    public function delete($data);

    /**
     * @param $identities
     *
     * @return ITag[]
     */
    public function batchGet($identities);

    /**
     * @param $data
     *
     * @return ITag[]
     */
    public function batchCreate($data);

    /**
     * @param $data
     *
     * @return ITag[]
     */
    public function batchUpdate($data);

    /**
     * @param $data
     *
     * @return ITag[]
     */
    public function batchDelete($data);
}