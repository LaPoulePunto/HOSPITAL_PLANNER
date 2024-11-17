<?php

namespace App\Factory;

use App\Entity\HealthProfessional;
use App\Repository\HealthProfessionalRepository;
use Doctrine\ORM\EntityRepository;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;
use Zenstruck\Foundry\Persistence\Proxy;
use Zenstruck\Foundry\Persistence\ProxyRepositoryDecorator;

/**
 * @extends PersistentProxyObjectFactory<HealthProfessional>
 *
 * @method        HealthProfessional|Proxy create(array|callable $attributes = [])
 * @method static HealthProfessional|Proxy createOne(array $attributes = [])
 * @method static HealthProfessional|Proxy find(object|array|mixed $criteria)
 * @method static HealthProfessional|Proxy findOrCreate(array $attributes)
 * @method static HealthProfessional|Proxy first(string $sortedField = 'id')
 * @method static HealthProfessional|Proxy last(string $sortedField = 'id')
 * @method static HealthProfessional|Proxy random(array $attributes = [])
 * @method static HealthProfessional|Proxy randomOrCreate(array $attributes = [])
 * @method static HealthProfessionalRepository|ProxyRepositoryDecorator repository()
 * @method static HealthProfessional[]|Proxy[] all()
 * @method static HealthProfessional[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static HealthProfessional[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static HealthProfessional[]|Proxy[] findBy(array $attributes)
 * @method static HealthProfessional[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static HealthProfessional[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class HealthProfessionalFactory extends PersistentProxyObjectFactory{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
        $this->translate = \Transliterator::create('Any-Lower; Latin-ASCII');
    }

    public static function class(): string
    {
        return HealthProfessional::class;
    }

    public function normalizeName(string $name): string
    {
        return preg_replace('/[^a-z]/', '-', mb_strtolower($this->translate->transliterate($name)));
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        $firstname = self::faker()->firstName();
        $lastname = self::faker()->lastName();
        $medicalJobs = [
            'Médecin généraliste',
            'Chirurgien',
            'Infirmier',
            'Urgentiste',
            'Kinésithérapeute',
        ];

        return [
            'email' => $this->normalizeName($firstname)
                .'.'
                .$this->normalizeName($lastname)
                .'@'
                .self::faker()->domainName(),
            'password' => 'password',
            'firstname' => $firstname,
            'lastname' => $lastname,
            'login' => $this->normalizeName($lastname).self::faker()->numberBetween(0, 999),
            'gender' => self::faker()->numberBetween(0, 1),
            'birthDate' => self::faker()->dateTimeBetween('-65 years', '-18 years'),
            'job' => self::faker()->randomElement($medicalJobs),
            'hiringDate' => self::faker()->dateTimeBetween('-10 years', 'now'),
            'departureDate' => self::faker()->optional()->dateTimeBetween('-10years','now'),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(HealthProfessional $healthProfessional): void {})
        ;
    }
}
