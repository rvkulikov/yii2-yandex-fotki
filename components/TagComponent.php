<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 17.12.2015
 * Time: 16:51
 */

namespace romkaChev\yandexFotki\components;


use romkaChev\yandexFotki\interfaces\components\ITagComponent;
use romkaChev\yandexFotki\interfaces\models\ITag;
use romkaChev\yandexFotki\traits\ModuleAccess;
use yii\base\Component;

class TagComponent extends Component implements ITagComponent
{

    use ModuleAccess;

    /**
     * @param int|string|int[]|string[] $id
     *
     * @return ITag
     */
    public function get($id)
    {
        // TODO: Implement get() method.
    }

    /**
     * @param mixed $data
     *
     * @return ITag
     */
    public function create($data)
    {
        // TODO: Implement create() method.
    }

    /**
     * @param mixed $data
     *
     * @return ITag
     */
    public function update($data)
    {
        // TODO: Implement update() method.
    }

    /**
     * @param mixed $data
     *
     * @return ITag
     */
    public function delete($data)
    {
        // TODO: Implement delete() method.
    }

    /**
     * @param $identities
     *
     * @return ITag[]
     */
    public function batchGet($identities)
    {
        // TODO: Implement batchGet() method.
    }

    /**
     * @param $data
     *
     * @return ITag[]
     */
    public function batchCreate($data)
    {
        // TODO: Implement batchCreate() method.
    }

    /**
     * @param $data
     *
     * @return ITag[]
     */
    public function batchUpdate($data)
    {
        // TODO: Implement batchUpdate() method.
    }

    /**
     * @param $data
     *
     * @return ITag[]
     */
    public function batchDelete($data)
    {
        // TODO: Implement batchDelete() method.
    }
}