<?php

namespace TMyers273\Tests\setup\models;

use Illuminate\Database\Eloquent\Model;
use TMyers273\Ownership\OwnedByUser;

class TestModel extends Model {
    use OwnedByUser;

    protected $guarded = [];
    protected $table = 'test_models';
}