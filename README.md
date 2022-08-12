# Spatie Phecks Example

```
php artisan phecks:run
```

## List of Spatie's style guide

https://spatie.be/guidelines/laravel-php

#### [Configuration](https://spatie.be/guidelines/laravel-php#content-configuration)
  * [ ] Configuration files must use kebab-case.
  * [ ] Configuration keys must use snake_case.
  * [ ] Avoid using the env helper outside of configuration files. Create a configuration value from the env variable like above.
#### [Artisan Commands](https://spatie.be/guidelines/laravel-php#content-artisan-commands)
  * [ ] The names given to artisan commands should all be kebab-cased.
#### [Routing](https://spatie.be/guidelines/laravel-php#content-routing)
  * [ ] Public-facing urls must use kebab-case.
  * [ ] Prefer to use the route tuple notation when possible.
  * [ ] Route names must use camelCase.
  * [ ] All routes have an HTTP verb, that's why we like to put the verb first when defining a route. It makes a group of routes very readable. Any other route options should come after it.
  * [ ] Route parameters should use camelCase.
  * [ ] A route url should not start with / unless the url would be an empty string.
#### [Controllers](https://spatie.be/guidelines/laravel-php#content-controllers)
  * [ ] Try to keep controllers simple and stick to the default CRUD keywords (index, create, store, show, edit, update, destroy). Extract a new controller if you need other actions.
#### [Views](https://spatie.be/guidelines/laravel-php#content-views)
  * [ ] View files must use camelCase.
#### [Validation](https://spatie.be/guidelines/laravel-php#content-validation)
  * [ ] All custom validation rules must use snake_case
#### [Authorization](https://spatie.be/guidelines/laravel-php#content-authorization)
  * [ ] Policies must use camelCase.
#### [Translations](https://spatie.be/guidelines/laravel-php#content-translations)
  * [ ] Translations must be rendered with the __ function. We prefer using this over @lang in Blade views because __ can be used in both Blade views and regular PHP code.
#### Namings:
  * [ ] [Resources](https://spatie.be/guidelines/laravel-php#content-resources-and-transformers) classes must be suffixed with `Resource`.
  * [ ] [Listeners](https://spatie.be/guidelines/laravel-php#content-listeners) classes must be suffixed with `Listener`, and not refer to an Event, but to what they do.
  * [ ] [Commands](https://spatie.be/guidelines/laravel-php#content-commands) classes must be suffixed with `Command`.
  * [ ] [Mailables](https://spatie.be/guidelines/laravel-php#content-mailables) must be suffixed with `Mail`.
  * [ ] [Enums](https://spatie.be/guidelines/laravel-php#content-enums-1) don't need to be suffixed with `Enum`.
