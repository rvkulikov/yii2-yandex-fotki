<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 17.12.2015
 * Time: 9:03
 */

namespace romkaChev\yandexFotki\interfaces\components;


use romkaChev\yandexFotki\interfaces\models\IAlbum;

interface IAlbumComponent extends ICrudComponent
{

    const CLASS_NAME = __CLASS__;

    /**
     * @param int|string|int[]|string[] $identity
     *
     * @return IAlbum
     */
    public function get($identity);

    /**
     * @param mixed $data
     *
     * @return IAlbum
     */
    public function create($data);

    /**
     * @param mixed $data
     *
     * @return IAlbum
     */
    public function update($data);

    /**
     * @param mixed $data
     *
     * @return IAlbum
     */
    public function delete($data);

    /**
     * @param mixed $root
     *
     * @return mixed
     */
    public function tree($root);

    /**
     * @param $identities
     *
     * @return IAlbum[]
     */
    public function multiGet($identities);

    /**
     * @param $data
     *
     * @return IAlbum[]
     */
    public function multiCreate($data);

    /**
     * @param $data
     *
     * @return IAlbum[]
     */
    public function multiUpdate($data);

    /**
     * @param $data
     *
     * @return IAlbum[]
     */
    public function multiDelete($data);

}