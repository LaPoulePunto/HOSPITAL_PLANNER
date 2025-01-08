<?php

namespace App\Factory;

use App\Entity\Admin;
use App\Repository\AdminRepository;
use Doctrine\ORM\EntityRepository;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;
use Zenstruck\Foundry\Persistence\Proxy;
use Zenstruck\Foundry\Persistence\ProxyRepositoryDecorator;

/**
 * @extends PersistentProxyObjectFactory<Admin>
 *
 * @method        Admin|Proxy create(array|callable $attributes = [])
 * @method static Admin|Proxy createOne(array $attributes = [])
 * @method static Admin|Proxy find(object|array|mixed $criteria)
 * @method static Admin|Proxy findOrCreate(array $attributes)
 * @method static Admin|Proxy first(string $sortedField = 'id')
 * @method static Admin|Proxy last(string $sortedField = 'id')
 * @method static Admin|Proxy random(array $attributes = [])
 * @method static Admin|Proxy randomOrCreate(array $attributes = [])
 * @method static AdminRepository|ProxyRepositoryDecorator repository()
 * @method static Admin[]|Proxy[] all()
 * @method static Admin[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Admin[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static Admin[]|Proxy[] findBy(array $attributes)
 * @method static Admin[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static Admin[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class AdminFactory extends PersistentProxyObjectFactory{
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
        return Admin::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'birthDate' => self::faker()->dateTime(),
            'email' => self::faker()->text(180),
            'isVerified' => self::faker()->boolean(),
            'password' => self::faker()->text(),
            'roles' => [],
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Admin $admin): void {})
        ;
    }
}
