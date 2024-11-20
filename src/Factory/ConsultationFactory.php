<?php

namespace App\Factory;

use App\Entity\Consultation;
use App\Repository\ConsultationRepository;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;
use Zenstruck\Foundry\Persistence\Proxy;
use Zenstruck\Foundry\Persistence\ProxyRepositoryDecorator;

/**
 * @extends PersistentProxyObjectFactory<Consultation>
 *
 * @method        Consultation|Proxy                              create(array|callable $attributes = [])
 * @method static Consultation|Proxy                              createOne(array $attributes = [])
 * @method static Consultation|Proxy                              find(object|array|mixed $criteria)
 * @method static Consultation|Proxy                              findOrCreate(array $attributes)
 * @method static Consultation|Proxy                              first(string $sortedField = 'id')
 * @method static Consultation|Proxy                              last(string $sortedField = 'id')
 * @method static Consultation|Proxy                              random(array $attributes = [])
 * @method static Consultation|Proxy                              randomOrCreate(array $attributes = [])
 * @method static ConsultationRepository|ProxyRepositoryDecorator repository()
 * @method static Consultation[]|Proxy[]                          all()
 * @method static Consultation[]|Proxy[]                          createMany(int $number, array|callable $attributes = [])
 * @method static Consultation[]|Proxy[]                          createSequence(iterable|callable $sequence)
 * @method static Consultation[]|Proxy[]                          findBy(array $attributes)
 * @method static Consultation[]|Proxy[]                          randomRange(int $min, int $max, array $attributes = [])
 * @method static Consultation[]|Proxy[]                          randomSet(int $number, array $attributes = [])
 */
final class ConsultationFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     */
    public function __construct()
    {
    }

    public static function class(): string
    {
        return Consultation::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     */
    protected function defaults(): array|callable
    {
        $startTime = new \DateTime();
        $startTime->setTime(rand(8, 20), self::faker()->randomElement([0, 15, 30, 45]));
        $endTime = clone $startTime;

        return [
            'date' => self::faker()->dateTimeBetween('-1 year'),
            'startTime' => $startTime,
            'endTime' => $endTime->modify('+30 minutes'),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Consultation $consultation): void {})
        ;
    }
}
