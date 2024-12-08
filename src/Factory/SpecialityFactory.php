<?php

namespace App\Factory;

use App\Entity\Speciality;
use App\Repository\SpecialityRepository;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;
use Zenstruck\Foundry\Persistence\Proxy;
use Zenstruck\Foundry\Persistence\ProxyRepositoryDecorator;

/**
 * @extends PersistentProxyObjectFactory<Speciality>
 *
 * @method        Speciality|Proxy                              create(array|callable $attributes = [])
 * @method static Speciality|Proxy                              createOne(array $attributes = [])
 * @method static Speciality|Proxy                              find(object|array|mixed $criteria)
 * @method static Speciality|Proxy                              findOrCreate(array $attributes)
 * @method static Speciality|Proxy                              first(string $sortedField = 'id')
 * @method static Speciality|Proxy                              last(string $sortedField = 'id')
 * @method static Speciality|Proxy                              random(array $attributes = [])
 * @method static Speciality|Proxy                              randomOrCreate(array $attributes = [])
 * @method static SpecialityRepository|ProxyRepositoryDecorator repository()
 * @method static Speciality[]|Proxy[]                          all()
 * @method static Speciality[]|Proxy[]                          createMany(int $number, array|callable $attributes = [])
 * @method static Speciality[]|Proxy[]                          createSequence(iterable|callable $sequence)
 * @method static Speciality[]|Proxy[]                          findBy(array $attributes)
 * @method static Speciality[]|Proxy[]                          randomRange(int $min, int $max, array $attributes = [])
 * @method static Speciality[]|Proxy[]                          randomSet(int $number, array $attributes = [])
 */
final class SpecialityFactory extends PersistentProxyObjectFactory
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
        return Speciality::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'label' => self::faker()->text(25),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): SpecialityFactory
    {
        return $this
            // ->afterInstantiate(function(Speciality $speciality): void {})
        ;
    }
}
