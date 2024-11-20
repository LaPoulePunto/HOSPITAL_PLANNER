<?php

namespace App\Factory;

use App\Entity\ConsultationType;
use App\Repository\ConsultationTypeRepository;
use Doctrine\ORM\EntityRepository;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;
use Zenstruck\Foundry\Persistence\Proxy;
use Zenstruck\Foundry\Persistence\ProxyRepositoryDecorator;

/**
 * @extends PersistentProxyObjectFactory<ConsultationType>
 *
 * @method        ConsultationType|Proxy create(array|callable $attributes = [])
 * @method static ConsultationType|Proxy createOne(array $attributes = [])
 * @method static ConsultationType|Proxy find(object|array|mixed $criteria)
 * @method static ConsultationType|Proxy findOrCreate(array $attributes)
 * @method static ConsultationType|Proxy first(string $sortedField = 'id')
 * @method static ConsultationType|Proxy last(string $sortedField = 'id')
 * @method static ConsultationType|Proxy random(array $attributes = [])
 * @method static ConsultationType|Proxy randomOrCreate(array $attributes = [])
 * @method static ConsultationTypeRepository|ProxyRepositoryDecorator repository()
 * @method static ConsultationType[]|Proxy[] all()
 * @method static ConsultationType[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static ConsultationType[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static ConsultationType[]|Proxy[] findBy(array $attributes)
 * @method static ConsultationType[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static ConsultationType[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class ConsultationTypeFactory extends PersistentProxyObjectFactory{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     */
    public function __construct()
    {
    }

    public static function class(): string
    {
        return ConsultationType::class;
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
            // ->afterInstantiate(function(ConsultationType $consultationType): void {})
        ;
    }
}
