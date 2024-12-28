<?php

namespace App\Factory;

use App\Entity\AvailabilitySplitSlots;
use App\Repository\AvailabilitySplitSlotsRepository;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;
use Zenstruck\Foundry\Persistence\Proxy;
use Zenstruck\Foundry\Persistence\ProxyRepositoryDecorator;

/**
 * @extends PersistentProxyObjectFactory<AvailabilitySplitSlots>
 *
 * @method        AvailabilitySplitSlots|Proxy                              create(array|callable $attributes = [])
 * @method static AvailabilitySplitSlots|Proxy                              createOne(array $attributes = [])
 * @method static AvailabilitySplitSlots|Proxy                              find(object|array|mixed $criteria)
 * @method static AvailabilitySplitSlots|Proxy                              findOrCreate(array $attributes)
 * @method static AvailabilitySplitSlots|Proxy                              first(string $sortedField = 'id')
 * @method static AvailabilitySplitSlots|Proxy                              last(string $sortedField = 'id')
 * @method static AvailabilitySplitSlots|Proxy                              random(array $attributes = [])
 * @method static AvailabilitySplitSlots|Proxy                              randomOrCreate(array $attributes = [])
 * @method static AvailabilitySplitSlotsRepository|ProxyRepositoryDecorator repository()
 * @method static AvailabilitySplitSlots[]|Proxy[]                          all()
 * @method static AvailabilitySplitSlots[]|Proxy[]                          createMany(int $number, array|callable $attributes = [])
 * @method static AvailabilitySplitSlots[]|Proxy[]                          createSequence(iterable|callable $sequence)
 * @method static AvailabilitySplitSlots[]|Proxy[]                          findBy(array $attributes)
 * @method static AvailabilitySplitSlots[]|Proxy[]                          randomRange(int $min, int $max, array $attributes = [])
 * @method static AvailabilitySplitSlots[]|Proxy[]                          randomSet(int $number, array $attributes = [])
 */
final class AvailabilitySplitSlotsFactory extends PersistentProxyObjectFactory
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
        return AvailabilitySplitSlots::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        $availability = AvailabilityFactory::createOne()->_real();

        $startTime = $availability->getStartTime();
        $endTime = (clone $startTime)->modify('+30 minutes');
        $date = $availability->getDate();

        return [
            'availability' => $availability,
            'date' => fn (array $attributes) => $attributes['availability']->getDate(),
            'startTime' => $startTime,
            'endTime' => (clone $startTime)->modify('+30 minutes'),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(AvailabilitySplitSlots $availabilitySplitSlots): void {})
        ;
    }
}
