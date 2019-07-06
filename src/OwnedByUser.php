<?php

namespace TMyers273\Ownership;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

trait OwnedByUser {

    /**
     * @param $value
     * @return mixed
     * @throws AuthorizationException
     * @throws \Exception
     */
    public function resolveRouteBinding($value) {
        $model = parent::resolveRouteBinding($value);

        if (! $model) {
            throw (new ModelNotFoundException)->setModel(get_class($this));
        }

        /** @var User $user */
        $user = auth()->user();

        if (!! config('ownership.allow_admin_override') && $user && $user->{config('ownership.user.admin_check')}($model)) {
            return $model;
        }

        if (!$user || ! $user->{config('ownership.user.ownership_check')}($model)) {
            throw (new AuthorizationException('This action is unauthorized'));
        }

        return $model;
    }

}