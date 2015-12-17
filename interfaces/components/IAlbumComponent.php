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

    /**
     * @param int|string|int[]|string[] $identity
     *
     * @return IAlbum|IAlbum[]
     */
    public function get($identity);

    /**
     * @param mixed $data
     *
     * @return IAlbum|IAlbum[]
     */
    public function create($data);

    /**
     * @param mixed $data
     *
     * @return IAlbum|IAlbum[]
     */
    public function update($data);

    /**
     * @param mixed $data
     *
     * @return IAlbum|IAlbum[]
     */
    public function delete($data);

    /**
     * @param mixed $root
     *
     * @return mixed
     */
    public function tree($root);

}