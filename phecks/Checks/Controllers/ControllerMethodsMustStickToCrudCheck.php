<?php

namespace Phecks\Checks\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Juampi92\Phecks\Domain\Contracts\Check;
use Juampi92\Phecks\Domain\DTOs\FileMatch;
use Juampi92\Phecks\Domain\Extractors\ClassExtractor;
use Juampi92\Phecks\Domain\Extractors\ReflectionClassExtractor;
use Juampi92\Phecks\Domain\Extractors\ReflectionMethodExtractor;
use Juampi92\Phecks\Domain\MatchCollection;
use Juampi92\Phecks\Domain\Pipes\Extractors\MethodExtractor;
use Juampi92\Phecks\Domain\Pipes\Filters\WhereExtendsClassFilter;
use Juampi92\Phecks\Domain\Sources\ClassSource;
use Juampi92\Phecks\Domain\Sources\FileSource;
use Juampi92\Phecks\Domain\Violations\ViolationBuilder;
use Roave\BetterReflection\Reflection\ReflectionClass;
use Roave\BetterReflection\Reflection\ReflectionMethod;

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
        private readonly ClassSource $source
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
            ->run()
            ->pipe(new MethodExtractor(\ReflectionMethod::IS_PUBLIC))
            ->reject(fn (ReflectionMethod $class): bool => $class->getDeclaringClass()->isTrait())
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
