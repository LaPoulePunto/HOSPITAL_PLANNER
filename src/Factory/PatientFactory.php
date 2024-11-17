<?php

namespace App\Factory;

use App\Entity\Patient;
use App\Repository\PatientRepository;
use Doctrine\ORM\EntityRepository;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;
use Zenstruck\Foundry\Persistence\Proxy;
use Zenstruck\Foundry\Persistence\ProxyRepositoryDecorator;

/**
 * @extends PersistentProxyObjectFactory<Patient>
 *
 * @method        Patient|Proxy create(array|callable $attributes = [])
 * @method static Patient|Proxy createOne(array $attributes = [])
 * @method static Patient|Proxy find(object|array|mixed $criteria)
 * @method static Patient|Proxy findOrCreate(array $attributes)
 * @method static Patient|Proxy first(string $sortedField = 'id')
 * @method static Patient|Proxy last(string $sortedField = 'id')
 * @method static Patient|Proxy random(array $attributes = [])
 * @method static Patient|Proxy randomOrCreate(array $attributes = [])
 * @method static PatientRepository|ProxyRepositoryDecorator repository()
 * @method static Patient[]|Proxy[] all()
 * @method static Patient[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Patient[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static Patient[]|Proxy[] findBy(array $attributes)
 * @method static Patient[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static Patient[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class PatientFactory extends PersistentProxyObjectFactory{
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
        return Patient::class;
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
            'city' => self::faker()->text(32),
            'email' => self::faker()->text(180),
            'isVerified' => self::faker()->boolean(),
            'password' => self::faker()->text(),
            'phone' => self::faker()->randomNumber(),
            'postCode' => self::faker()->randomNumber(),
            'roles' => [],
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Patient $patient): void {})
        ;
    }
}
