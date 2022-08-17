<?php

namespace Phecks\Checks\Controllers;

use Juampi92\Phecks\Domain\Contracts\Check;
use Juampi92\Phecks\Domain\DTOs\FileMatch;
use Juampi92\Phecks\Domain\Extractors\ClassExtractor;
use Juampi92\Phecks\Domain\Extractors\ReflectionClassExtractor;
use Juampi92\Phecks\Domain\Extractors\ReflectionMethodExtractor;
use Juampi92\Phecks\Domain\MatchCollection;
use Juampi92\Phecks\Domain\Sources\FileSource;
use Juampi92\Phecks\Domain\Violations\ViolationBuilder;
use ReflectionMethod;

/**
 * @implements Check<ReflectionMethod>
 */
class ControllerMethodsMustStickToCrudCheck implements Check
{
    private const CRUD_KEYWORDS = [
        'index', 'create', 'store', 'show', 'edit', 'update', 'destroy',
    ];

    private const IGNORE_CLASSES = [
        \Illuminate\Routing\Controller::class,
        \App\Http\Controllers\Controller::class,
    ];

    public function __construct(
        private readonly FileSource $source
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
            ->directory('./app/Http/Controllers')
            ->recursive()
            ->run()
            ->extract(new ClassExtractor())
            ->extract(new ReflectionClassExtractor())
            ->extract(new ReflectionMethodExtractor(ReflectionMethod::IS_PUBLIC))
            ->reject(fn (ReflectionMethod $method) => in_array(
                $method->getDeclaringClass()->getName(),
                self::IGNORE_CLASSES
            ))
            ->reject(fn (ReflectionMethod $method) => in_array(
                $method->getName(),
                self::CRUD_KEYWORDS
            ));
    }

    /**
     * @param  ReflectionMethod  $match
     * @return array<ViolationBuilder>
     */
    public function processMatch($match, FileMatch $file): array
    {
        return [
            ViolationBuilder::make()
                ->message("The method '{$match->getName()}' is not a default CRUD keyword. Try to stick to them or extract to a new controller if you need other actions.")
                ->setFile(new FileMatch(
                    (string) $match->getFileName(),
                    (int) $match->getStartLine(),
                )),
        ];
    }
}
