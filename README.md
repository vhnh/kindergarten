![VHNH](https://avatars3.githubusercontent.com/u/66573047?s=200)

# vhnh/kindergarten
Sorry, Joe. You're too young to party.

![tests](https://github.com/vhnh/kindergarten/workflows/tests/badge.svg)

## What does the package provide?

The Vhnh Kindergarten package adds a route middleware to your [Laravel](https://github.com/laravel/laravel) application. The middleware checks if a `verified_age` key exists within the session.

For SEO  purposes the most popular search engine crawlers are whitelisted.

```php
Route::middleware('kindergarten')->get('/booze', BoozeController::class);
```

## License
The Vhnh Kindergarten package is open-sourced software licensed under the [MIT](http://opensource.org/licenses/MIT) license.