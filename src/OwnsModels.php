<?php

namespace TMyers273\Ownership;

use Illuminate\Database\Eloquent\Model;
use TMyers273\Tests\setup\models\TestModel;

/**
 * You will want to edit both of the methods in this file
 *
 * Trait OwnsModels
 * @package TMyers273\Ownership
 */
trait OwnsModels {

    /**
     * @return bool
     */
    public function isAdmin(): bool {
        return $this->id == 123;
    }

    /**
     * Ownership check method. Should return a
     * bool if the user owns the passed Model
     *
     * @param Model $model
     * @return bool
     * @throws \Exception
     */
    public function owns(Model $model): bool {
        switch (get_class($model)) {
            case (TestModel::class):
                return $this->id == $model->user_id;
            default:
                throw new \Exception("No implementation for owns on " . get_class($model));
        }
    }

}