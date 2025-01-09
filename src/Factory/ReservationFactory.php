<?php

namespace App\Factory;

use App\Entity\Reservation;
use App\Repository\ReservationRepository;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;
use Zenstruck\Foundry\Persistence\Proxy;
use Zenstruck\Foundry\Persistence\ProxyRepositoryDecorator;

/**
 * @extends PersistentProxyObjectFactory<Reservation>
 *
 * @method        Reservation|Proxy                              create(array|callable $attributes = [])
 * @method static Reservation|Proxy                              createOne(array $attributes = [])
 * @method static Reservation|Proxy                              find(object|array|mixed $criteria)
 * @method static Reservation|Proxy                              findOrCreate(array $attributes)
 * @method static Reservation|Proxy                              first(string $sortedField = 'id')
 * @method static Reservation|Proxy                              last(string $sortedField = 'id')
 * @method static Reservation|Proxy                              random(array $attributes = [])
 * @method static Reservation|Proxy                              randomOrCreate(array $attributes = [])
 * @method static ReservationRepository|ProxyRepositoryDecorator repository()
 * @method static Reservation[]|Proxy[]                          all()
 * @method static Reservation[]|Proxy[]                          createMany(int $number, array|callable $attributes = [])
 * @method static Reservation[]|Proxy[]                          createSequence(iterable|callable $sequence)
 * @method static Reservation[]|Proxy[]                          findBy(array $attributes)
 * @method static Reservation[]|Proxy[]                          randomRange(int $min, int $max, array $attributes = [])
 * @method static Reservation[]|Proxy[]                          randomSet(int $number, array $attributes = [])
 */
final class ReservationFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     */
    public function __construct()
    {
    }

    public static function class(): string
    {
        return Reservation::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     */
    protected function defaults(): array|callable
    {
        $startTime = new \DateTime();
        $startTime->setTime(rand(8, 20), self::faker()->randomElement([0, 15, 30, 45]))
        ->modify('+'.rand(0, 29).'days');
        $endTime = clone $startTime;

        return [
            'startTime' => $startTime,
            'endTime' => $endTime->modify('+30 minutes'),
            'material' => MaterialFactory::new(),
            'healthprofessional' => HealthProfessionalFactory::new(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): ReservationFactory
    {
        return $this
            // ->afterInstantiate(function(Reservation $reservation): void {})
        ;
    }
}
