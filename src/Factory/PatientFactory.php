<?php

namespace App\Factory;

use App\Entity\Patient;
use App\Repository\PatientRepository;
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
final class PatientFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     */
    public function __construct()
    {
        $this->translate = \Transliterator::create('Any-Lower; Latin-ASCII');
    }

    public static function class(): string
    {
        return Patient::class;
    }

    public function normalizeName(string $name): string
    {
        return preg_replace('/[^a-z]/', '-', mb_strtolower($this->translate->transliterate($name)));
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     */
    protected function defaults(): array|callable
    {
        $firstname = self::faker()->firstName();
        $lastname = self::faker()->lastName();

        return [
            'email' => $this->normalizeName($firstname)
                .'.'
                .$this->normalizeName($lastname)
                .'@'
                .self::faker()->domainName(),
            'password' => 'password',
            'firstname' => $firstname,
            'lastname' => $lastname,
            'city' => self::faker()->city(),
            'postCode' => self::faker()->numberBetween(1000, 99999),
            'phone' => self::faker()->phoneNumber(),
            'address' => self::faker()->numberBetween(1, 999).' '.self::faker()->streetName(),
            'bloodGroup' => self::faker()->randomElement(['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-']),
            'allergies' => self::faker()->optional()->sentence(),
            'comments' => self::faker()->optional()->sentence(),
            'treatments' => self::faker()->optional()->sentence(),
            'birthDate' => self::faker()->dateTimeBetween('-80 years', '-18 years'),
            'login' => $this->normalizeName($lastname).self::faker()->numberBetween(0, 999),
            'gender' => self::faker()->numberBetween(0, 1),
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
