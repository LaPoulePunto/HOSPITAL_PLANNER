<?php

namespace App\Factory;

use App\Entity\Availability;
use App\Repository\AvailabilityRepository;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;
use Zenstruck\Foundry\Persistence\Proxy;
use Zenstruck\Foundry\Persistence\ProxyRepositoryDecorator;

/**
 * @extends PersistentProxyObjectFactory<Availability>
 *
 * @method        Availability|Proxy                              create(array|callable $attributes = [])
 * @method static Availability|Proxy                              createOne(array $attributes = [])
 * @method static Availability|Proxy                              find(object|array|mixed $criteria)
 * @method static Availability|Proxy                              findOrCreate(array $attributes)
 * @method static Availability|Proxy                              first(string $sortedField = 'id')
 * @method static Availability|Proxy                              last(string $sortedField = 'id')
 * @method static Availability|Proxy                              random(array $attributes = [])
 * @method static Availability|Proxy                              randomOrCreate(array $attributes = [])
 * @method static AvailabilityRepository|ProxyRepositoryDecorator repository()
 * @method static Availability[]|Proxy[]                          all()
 * @method static Availability[]|Proxy[]                          createMany(int $number, array|callable $attributes = [])
 * @method static Availability[]|Proxy[]                          createSequence(iterable|callable $sequence)
 * @method static Availability[]|Proxy[]                          findBy(array $attributes)
 * @method static Availability[]|Proxy[]                          randomRange(int $min, int $max, array $attributes = [])
 * @method static Availability[]|Proxy[]                          randomSet(int $number, array $attributes = [])
 */
final class AvailabilityFactory extends PersistentProxyObjectFactory
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
        return Availability::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        $startTime = new \DateTime();
        $startTime->setTime(rand(8, 20), self::faker()->randomElement([0, 15, 30, 45]));
        $endTime = clone $startTime;

        return [
            'date' => self::faker()->dateTimeBetween('now', '+1 month'),
            'startTime' => $startTime,
            'endTime' => $endTime->modify('+30 minutes'),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): AvailabilityFactory
    {
        return $this
            // ->afterInstantiate(function(Availability $availability): void {})
        ;
    }
}
