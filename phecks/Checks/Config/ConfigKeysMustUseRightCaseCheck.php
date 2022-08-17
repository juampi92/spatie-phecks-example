<?php

namespace Phecks\Checks\Config;

use Illuminate\Support\Str;
use Juampi92\Phecks\Domain\Contracts\Check;
use Juampi92\Phecks\Domain\DTOs\FileMatch;
use Juampi92\Phecks\Domain\MatchCollection;
use Juampi92\Phecks\Domain\Sources\ConfigSource;
use Juampi92\Phecks\Domain\Violations\ViolationBuilder;

/**
 * @template TConfig of array{key: string, value: mixed}
 * @implements Check<TConfig>
 */
class ConfigKeysMustUseRightCaseCheck implements Check
{
    private const IGNORED_CONFIGS = [
        'flare.*',
        'app.aliases.*',
        'broadcasting.connections.pusher.options.useTLS',
        'logging.channels.papertrail.handler_with.connectionString',
    ];

    public function __construct(
        private readonly ConfigSource $source
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
                /** @param  TConfig  $config */
                fn ($config): bool => collect(self::IGNORED_CONFIGS)
                    ->contains(fn ($pattern) => Str::is($pattern, $config['key']))
            );
    }

    /**
     * Process here the output of the method getMatches.
     * This method must return an array of ViolationBuilder instances.
     * Ignore the match returning an empty array.
     *
     * @param  TConfig  $match
     * @param  FileMatch  $file
     * @return array<ViolationBuilder>
     */
    public function processMatch($match, FileMatch $file): array
    {
        $nonSnakeCaseKeys = Str::of($match['key'])
            ->explode('.')
            ->reject(fn (string $key): bool => Str::snake($key) == $key);

        if ($nonSnakeCaseKeys->isEmpty()) {
            return [];
        }

        return [
            ViolationBuilder::make()
                ->message("The config key ({$match['key']}) must be using snake_case."),
        ];
    }
}
