<?php

namespace Phecks\Checks\Routes;

use Illuminate\Support\Str;
use Juampi92\Phecks\Domain\Contracts\Check;
use Juampi92\Phecks\Domain\DTOs\FileMatch;
use Juampi92\Phecks\Domain\MatchCollection;
use Juampi92\Phecks\Domain\Sources\RouteCommandSource;
use Juampi92\Phecks\Domain\Violations\ViolationBuilder;

/**
 * @implements Check<array{uri: string}>
 */
class RouteParametersMustUseCamelCaseCheck implements Check
{
    private const EXCLUDE = [
        'sanctum/*',
    ];

    public function __construct(
        private readonly RouteCommandSource $source
    ) {
    }

    /**
     * Use a Source to find matches.
     * You can filter, reject and
     *
     * @return MatchCollection
     */
    public function getMatches(): MatchCollection
    {
        return $this->source
            ->run()
            ->reject(
                fn (array $route): bool => collect(self::EXCLUDE)
                    ->contains(fn ($pattern) => Str::is($pattern, $route['uri']))
            );
    }

    /**
     * @param  array{uri: string}  $match
     * @param  FileMatch  $file
     * @return array<ViolationBuilder>
     */
    public function processMatch($match, FileMatch $file): array
    {
        return Str::matchAll('/\{([^\?\}]+)\??\}/m', $match['uri'])
            ->reject(fn (string $parameter) => Str::camel($parameter) === $parameter)
            ->map(fn (string $variable) => ViolationBuilder::make()
                    ->message("The route name parameter '{$variable}' must use camelCase."),
            )
            ->all();
    }
}
