# Laravel Ownership

A simple package to do Model ownership checks automatically via Laravel's Route Model Binding.

**What's it do?**

```php
// Let's whip up a few Users and a Post to demonstrate
$owner = factory(User::class)->create();
$post = factory(Post::class)->create([
    'user_id' => $owner->id
]);

$otherUser = factory(User::class)->create();
$adminUser = factory(USer::class)->create([
    'is_admin' => true
]);
```

```
// This will be a successful call, since $owner owns the $post
$this->be($owner);
$this->json('PATCH', '/post/' . $post->id, [
    'title' => 'Edited by Owner'
]);
```

```
// This will fail, since $otherUser does not own the $post
$this->be($otherUser);
$this->json('PATCH', '/post/' . $post->id, [
    'title' => 'Edited by Owner'
]);
```

```
// This will be a successful call, since $adminUser can override the ownership check (by default)
$this->be($adminUser);
$this->json('PATCH', '/post/' . $post->id, [
    'title' => 'Edited by Owner'
]);
```

```
// This will fail, since 12345 is a made up Post id
$this->be($owner);
$this->json('PATCH', '/post/12345', [
    'title' => 'Edited by Owner'
]);
```

# Installation

`composer require tmyers273/laravel-ownership`

`php artisan vendor:publish --tag=laravel-ownership-config --tag=laravel-ownership-trait`

Add `OwnsModels` trait to your `User` model
```php
use App\Traits\OwnsModels;

class User extends Authenticatable
{
    use OwnsModels;
}
```

Add `OwnedByUser` to each model you want to validate ownership on.
```php
use TMyers273\Ownership\OwnedByUser;

class Post extends Model
{
    use OwnedByUser;
}
```

Modify the `isAdmin` and `owns` methods on the `OwnsModels` trait to fit your needs!