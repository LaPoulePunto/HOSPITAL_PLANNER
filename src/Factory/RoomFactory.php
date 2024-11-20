<?php

namespace App\Factory;

use App\Entity\Room;
use App\Repository\RoomRepository;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;
use Zenstruck\Foundry\Persistence\Proxy;
use Zenstruck\Foundry\Persistence\ProxyRepositoryDecorator;

/**
 * @extends PersistentProxyObjectFactory<Room>
 *
 * @method        Room|Proxy                              create(array|callable $attributes = [])
 * @method static Room|Proxy                              createOne(array $attributes = [])
 * @method static Room|Proxy                              find(object|array|mixed $criteria)
 * @method static Room|Proxy                              findOrCreate(array $attributes)
 * @method static Room|Proxy                              first(string $sortedField = 'id')
 * @method static Room|Proxy                              last(string $sortedField = 'id')
 * @method static Room|Proxy                              random(array $attributes = [])
 * @method static Room|Proxy                              randomOrCreate(array $attributes = [])
 * @method static RoomRepository|ProxyRepositoryDecorator repository()
 * @method static Room[]|Proxy[]                          all()
 * @method static Room[]|Proxy[]                          createMany(int $number, array|callable $attributes = [])
 * @method static Room[]|Proxy[]                          createSequence(iterable|callable $sequence)
 * @method static Room[]|Proxy[]                          findBy(array $attributes)
 * @method static Room[]|Proxy[]                          randomRange(int $min, int $max, array $attributes = [])
 * @method static Room[]|Proxy[]                          randomSet(int $number, array $attributes = [])
 */
final class RoomFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     */
    public function __construct()
    {
    }

    public static function class(): string
    {
        return Room::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     */
    protected function defaults(): array|callable
    {
        return [
            'floor' => self::faker()->lexify('???'),
            'num' => self::faker()->randomNumber(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Room $room): void {})
        ;
    }
}
