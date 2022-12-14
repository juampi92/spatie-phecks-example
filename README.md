# Spatie Phecks Example

This is an example repository of a Phecks implementation using [Spatie's styleguides](https://spatie.be/guidelines/laravel-php).

```
php artisan phecks:run
```

## List of Spatie's style guide

#### [Configuration](https://spatie.be/guidelines/laravel-php#content-configuration)
  * [x] Configuration files must use kebab-case ([ConfigFilesMustUseRightCaseCheck](spatie-phecks-example/blob/main/phecks/Checks/Config/ConfigFilesMustUseRightCaseCheck.php)).
  * [x] Configuration keys must use snake_case ([ConfigKeysMustUseRightCaseCheck](spatie-phecks-example/blob/main/phecks/Checks/Config/ConfigKeysMustUseRightCaseCheck.php)).
  * [ ] Avoid using the env helper outside of configuration files. Create a configuration value from the env variable like above.
#### [Artisan Commands](https://spatie.be/guidelines/laravel-php#content-artisan-commands)
  * [x] The names given to artisan commands should all be kebab-cased. ([CommandNamesShouldUseKebabCaseCheck](spatie-phecks-example/blob/main/phecks/Checks/Artisan/CommandNamesShouldUseKebabCaseCheck.php))
#### [Routing](https://spatie.be/guidelines/laravel-php#content-routing)
  * [x] Public-facing urls must use kebab-case ([PublicFacingUrlsMustUseKebabCaseCheck](spatie-phecks-example/blob/main/phecks/Checks/Routes/PublicFacingUrlsMustUseKebabCaseCheck.php)).
  * [ ] Prefer to use the route tuple notation when possible.
  * [x] Route names must use camelCase ([RouteNamesMustUseCamelCaseCheck](spatie-phecks-example/blob/main/phecks/Checks/Routes/RouteNamesMustUseCamelCaseCheck.php)).
  * [ ] All routes have an HTTP verb, that's why we like to put the verb first when defining a route. It makes a group of routes very readable. Any other route options should come after it.
  * [x] Route parameters should use camelCase ([RouteParametersMustUseCamelCaseCheck](spatie-phecks-example/blob/main/phecks/Checks/Routes/RouteParametersMustUseCamelCaseCheck.php)).
  * [ ] A route url should not start with / unless the url would be an empty string.
#### [Controllers](https://spatie.be/guidelines/laravel-php#content-controllers)
  * [x] Try to keep controllers simple and stick to the default CRUD keywords (index, create, store, show, edit, update, destroy). Extract a new controller if you need other actions. ([ControllerMethodsMustStickToCrudCheck](spatie-phecks-example/blob/main/phecks/Checks/Controllers/ControllerMethodsMustStickToCrudCheck.php)).
#### [Views](https://spatie.be/guidelines/laravel-php#content-views)
  * [x] View files must use camelCase. ([ViewFilesMustUseCamelCase](spatie-phecks-example/blob/main/phecks/Checks/Views/ViewFilesMustUseCamelCaseCheck.php)).
#### [Validation](https://spatie.be/guidelines/laravel-php#content-validation)
  * [ ] All custom validation rules must use snake_case
#### [Authorization](https://spatie.be/guidelines/laravel-php#content-authorization)
  * [ ] Policies must use camelCase.
#### [Translations](https://spatie.be/guidelines/laravel-php#content-translations)
  * [ ] Translations must be rendered with the __ function. We prefer using this over @lang in Blade views because __ can be used in both Blade views and regular PHP code.
#### Namings:
  * [ ] [Resources](https://spatie.be/guidelines/laravel-php#content-resources-and-transformers) classes must be suffixed with `Resource`.
  * [ ] [Listeners](https://spatie.be/guidelines/laravel-php#content-listeners) classes must be suffixed with `Listener`, and not refer to an Event, but to what they do.
  * [ ] [Commands](https://spatie.be/guidelines/laravel-php#content-commands) classes must be suffixed with `Command`. ([ConsoleClassesMustBeSuffixedWithCommandCheck](spatie-phecks-example/blob/main/phecks/Checks/Console/ConsoleClassesMustBeSuffixedWithCommandCheck.php)).
  * [ ] [Mailables](https://spatie.be/guidelines/laravel-php#content-mailables) must be suffixed with `Mail`.
  * [ ] [Enums](https://spatie.be/guidelines/laravel-php#content-enums-1) don't need to be suffixed with `Enum`.
