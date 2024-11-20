<?php

namespace App\Factory;

use App\Entity\Patient;
use App\Repository\PatientRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;
use Zenstruck\Foundry\Persistence\Proxy;
use Zenstruck\Foundry\Persistence\ProxyRepositoryDecorator;

/**
 * @extends PersistentProxyObjectFactory<Patient>
 *
 * @method        Patient|Proxy                              create(array|callable $attributes = [])
 * @method static Patient|Proxy                              createOne(array $attributes = [])
 * @method static Patient|Proxy                              find(object|array|mixed $criteria)
 * @method static Patient|Proxy                              findOrCreate(array $attributes)
 * @method static Patient|Proxy                              first(string $sortedField = 'id')
 * @method static Patient|Proxy                              last(string $sortedField = 'id')
 * @method static Patient|Proxy                              random(array $attributes = [])
 * @method static Patient|Proxy                              randomOrCreate(array $attributes = [])
 * @method static PatientRepository|ProxyRepositoryDecorator repository()
 * @method static Patient[]|Proxy[]                          all()
 * @method static Patient[]|Proxy[]                          createMany(int $number, array|callable $attributes = [])
 * @method static Patient[]|Proxy[]                          createSequence(iterable|callable $sequence)
 * @method static Patient[]|Proxy[]                          findBy(array $attributes)
 * @method static Patient[]|Proxy[]                          randomRange(int $min, int $max, array $attributes = [])
 * @method static Patient[]|Proxy[]                          randomSet(int $number, array $attributes = [])
 */
final class PatientFactory extends UserFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     */
    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        parent::__construct($userPasswordHasher);
    }

    public static function class(): string
    {
        return Patient::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     */
    protected function defaults(): array|callable
    {
        return array_merge(parent::defaults(), [
            'city' => self::faker()->city(),
            'postCode' => self::faker()->numberBetween(1000, 99999),
            'phone' => self::faker()->phoneNumber(),
            'address' => self::faker()->numberBetween(1, 999).' '.self::faker()->streetName(),
            'bloodGroup' => self::faker()->randomElement(['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-']),
            'allergies' => self::faker()->optional()->sentence(),
            'comments' => self::faker()->optional()->sentence(),
            'treatments' => self::faker()->optional()->sentence(),
        ]);
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return parent::initialize();
    }
}
