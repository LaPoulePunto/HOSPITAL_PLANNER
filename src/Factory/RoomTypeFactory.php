<?php

namespace App\Factory;

use App\Entity\RoomType;
use App\Repository\RoomTypeRepository;
use Doctrine\ORM\EntityRepository;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;
use Zenstruck\Foundry\Persistence\Proxy;
use Zenstruck\Foundry\Persistence\ProxyRepositoryDecorator;

/**
 * @extends PersistentProxyObjectFactory<RoomType>
 *
 * @method        RoomType|Proxy create(array|callable $attributes = [])
 * @method static RoomType|Proxy createOne(array $attributes = [])
 * @method static RoomType|Proxy find(object|array|mixed $criteria)
 * @method static RoomType|Proxy findOrCreate(array $attributes)
 * @method static RoomType|Proxy first(string $sortedField = 'id')
 * @method static RoomType|Proxy last(string $sortedField = 'id')
 * @method static RoomType|Proxy random(array $attributes = [])
 * @method static RoomType|Proxy randomOrCreate(array $attributes = [])
 * @method static RoomTypeRepository|ProxyRepositoryDecorator repository()
 * @method static RoomType[]|Proxy[] all()
 * @method static RoomType[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static RoomType[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static RoomType[]|Proxy[] findBy(array $attributes)
 * @method static RoomType[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static RoomType[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class RoomTypeFactory extends PersistentProxyObjectFactory{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     */
    public function __construct()
    {
    }

    public static function class(): string
    {
        return RoomType::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     */
    protected function defaults(): array|callable
    {
        return [
            'label' => self::faker()->text(32),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(RoomType $roomType): void {})
        ;
    }
}
