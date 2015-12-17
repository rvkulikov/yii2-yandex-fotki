<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 17.12.2015
 * Time: 15:39
 */

namespace romkaChev\yandexFotki\components;


use romkaChev\yandexFotki\interfaces\components\IAlbumComponent;
use romkaChev\yandexFotki\interfaces\models\IAlbum;
use romkaChev\yandexFotki\traits\ModuleAccess;
use yii\base\Component;

class AlbumComponent extends Component implements IAlbumComponent
{

    use ModuleAccess;

    /**
     * @param int|string|int[]|string[] $identity
     *
     * @return IAlbum
     */
    public function get($identity)
    {
        // TODO: Implement get() method.
    }

    /**
     * @param mixed $data
     *
     * @return IAlbum
     */
    public function create($data)
    {
        // TODO: Implement create() method.
    }

    /**
     * @param mixed $data
     *
     * @return IAlbum
     */
    public function update($data)
    {
        // TODO: Implement update() method.
    }

    /**
     * @param mixed $data
     *
     * @return IAlbum
     */
    public function delete($data)
    {
        // TODO: Implement delete() method.
    }

    /**
     * @param mixed $root
     *
     * @return mixed
     */
    public function tree($root)
    {
        // TODO: Implement tree() method.
    }

    /**
     * @param $identities
     *
     * @return IAlbum[]
     */
    public function batchGet($identities)
    {
        // TODO: Implement multiGet() method.
    }

    /**
     * @param $data
     *
     * @return IAlbum[]
     */
    public function batchCreate($data)
    {
        // TODO: Implement multiCreate() method.
    }

    /**
     * @param $data
     *
     * @return IAlbum[]
     */
    public function batchUpdate($data)
    {
        // TODO: Implement multiUpdate() method.
    }

    /**
     * @param $data
     *
     * @return IAlbum[]
     */
    public function batchDelete($data)
    {
        // TODO: Implement multiDelete() method.
    }

}