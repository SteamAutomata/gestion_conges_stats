<?php

namespace App\Factory;

use App\Entity\Groupe;
use App\Repository\GroupeRepository;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;
use Zenstruck\Foundry\Persistence\Proxy;
use Zenstruck\Foundry\Persistence\ProxyRepositoryDecorator;

/**
 * @extends PersistentProxyObjectFactory<Groupe>
 *
 * @method        Groupe|Proxy                              create(array|callable $attributes = [])
 * @method static Groupe|Proxy                              createOne(array $attributes = [])
 * @method static Groupe|Proxy                              find(object|array|mixed $criteria)
 * @method static Groupe|Proxy                              findOrCreate(array $attributes)
 * @method static Groupe|Proxy                              first(string $sortedField = 'id')
 * @method static Groupe|Proxy                              last(string $sortedField = 'id')
 * @method static Groupe|Proxy                              random(array $attributes = [])
 * @method static Groupe|Proxy                              randomOrCreate(array $attributes = [])
 * @method static GroupeRepository|ProxyRepositoryDecorator repository()
 * @method static Groupe[]|Proxy[]                          all()
 * @method static Groupe[]|Proxy[]                          createMany(int $number, array|callable $attributes = [])
 * @method static Groupe[]|Proxy[]                          createSequence(iterable|callable $sequence)
 * @method static Groupe[]|Proxy[]                          findBy(array $attributes)
 * @method static Groupe[]|Proxy[]                          randomRange(int $min, int $max, array $attributes = [])
 * @method static Groupe[]|Proxy[]                          randomSet(int $number, array $attributes = [])
 */
final class GroupeFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
    }

    public static function class(): string
    {
        return Groupe::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'nom' => self::faker()->text(97),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Groupe $groupe): void {})
        ;
    }
}
