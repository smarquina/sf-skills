<?php

namespace App\Tests\Factory\Project;

use App\Entity\Project\Project;
use JetBrains\PhpStorm\ArrayShape;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Project>
 *
 * @method static Project|Proxy createOne(array $attributes = [])
 * @method static Project[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Project|Proxy find(object|array|mixed $criteria)
 * @method static Project|Proxy findOrCreate(array $attributes)
 * @method static Project|Proxy first(string $sortedField = 'id')
 * @method static Project|Proxy last(string $sortedField = 'id')
 * @method static Project|Proxy random(array $attributes = [])
 * @method static Project|Proxy randomOrCreate(array $attributes = [])
 * @method static Project[]|Proxy[] all()
 * @method static Project[]|Proxy[] findBy(array $attributes)
 * @method static Project[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Project[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method Project|Proxy create(array|callable $attributes = [])
 */
final class ProjectFactory extends ModelFactory {

    #[ArrayShape(['name'      => "string",
                  'startDate' => \DateTime::class,
                  'amount'    => "int",
                  'createdAt' => \DateTime::class])]
    protected function getDefaults(): array
    {
        return [
            'name'      => self::faker()->text(),
            'startDate' => new \DateTime(),
            'amount'    => self::faker()->randomNumber(),
            'createdAt' => new \DateTime(),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this// ->afterInstantiate(function(Project $project): void {})
            ;
    }

    protected static function getClass(): string
    {
        return Project::class;
    }
}
