<?php

namespace TMyers273\Tests;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use TMyers273\Tests\setup\models\TestModel;
use TMyers273\Tests\setup\models\User;

class TraitTest extends TestCase {

    use DatabaseMigrations;

    public function setUp(): void {
        parent::setUp();

        $this->loadMigrationsFrom(__DIR__ . '/setup/migrations');
    }

    protected function getEnvironmentSetUp($app) {
        $app['config']->set('database.default', 'testing');
        $app['config']->set('ownership', require './src/config/ownership.php');
    }

    /** @test */
    public function owner_can_load_their_own() {
        // 1. Given
        $owner = User::create();
        $this->be($owner);

        $model = TestModel::create([
            'user_id' => $owner->id,
        ]);

        // 2. Do this
        $result = $model->resolveRouteBinding($model->id);

        // 3.1 Expect
        $this->assertEquals($model->toArray(), $result->toArray());
    }

    /** @test */
    public function other_user_cannot_load_someone_elses() {
        // 1. Given
        $other = User::create();
        $this->be($other);

        $model = TestModel::create([
            'user_id' => $other->id+1,
        ]);

        $this->expectException(AuthorizationException::class);

        // 2. Do this
        $model->resolveRouteBinding($model->id);

        // 3.1 Expect
    }

    /** @test */
    public function admin_can_load_others_if_override_is_on() {
        // 1. Given
        $admin = User::create(['id' => 123,]);
        $this->be($admin);

        $model = TestModel::create([
            'user_id' => $admin->id+1,
        ]);

        // 2. Do this
        $result = $model->resolveRouteBinding($model->id);

        // 3.1 Expect
        $this->assertEquals($model->toArray(), $result->toArray());
    }

    /** @test */
    public function admin_cannot_load_others_if_override_is_off() {
        // 1. Given
        $admin = User::create(['id' => 123,]);
        $this->be($admin);
        config(['ownership.allow_admin_override' => false]);

        $model = TestModel::create([
            'user_id' => $admin->id+1,
        ]);

        $this->expectException(AuthorizationException::class);

        // 2. Do this
        $result = $model->resolveRouteBinding($model->id);

        // 3.1 Expect
    }
}
