<?php

namespace App\Factory;

use App\Entity\HealthProfessional;
use App\Repository\HealthProfessionalRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;
use Zenstruck\Foundry\Persistence\Proxy;
use Zenstruck\Foundry\Persistence\ProxyRepositoryDecorator;

/**
 * @extends PersistentProxyObjectFactory<HealthProfessional>
 *
 * @method        HealthProfessional|Proxy                              create(array|callable $attributes = [])
 * @method static HealthProfessional|Proxy                              createOne(array $attributes = [])
 * @method static HealthProfessional|Proxy                              find(object|array|mixed $criteria)
 * @method static HealthProfessional|Proxy                              findOrCreate(array $attributes)
 * @method static HealthProfessional|Proxy                              first(string $sortedField = 'id')
 * @method static HealthProfessional|Proxy                              last(string $sortedField = 'id')
 * @method static HealthProfessional|Proxy                              random(array $attributes = [])
 * @method static HealthProfessional|Proxy                              randomOrCreate(array $attributes = [])
 * @method static HealthProfessionalRepository|ProxyRepositoryDecorator repository()
 * @method static HealthProfessional[]|Proxy[]                          all()
 * @method static HealthProfessional[]|Proxy[]                          createMany(int $number, array|callable $attributes = [])
 * @method static HealthProfessional[]|Proxy[]                          createSequence(iterable|callable $sequence)
 * @method static HealthProfessional[]|Proxy[]                          findBy(array $attributes)
 * @method static HealthProfessional[]|Proxy[]                          randomRange(int $min, int $max, array $attributes = [])
 * @method static HealthProfessional[]|Proxy[]                          randomSet(int $number, array $attributes = [])
 */
final class HealthProfessionalFactory extends UserFactory
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
        return HealthProfessional::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     */
    protected function defaults(): array|callable
    {
        $medicalJobs = [
            'Médecin généraliste',
            'Chirurgien',
            'Infirmier',
            'Urgentiste',
            'Kinésithérapeute',
        ];
        return array_merge(parent::defaults(),[
            'job' => self::faker()->randomElement($medicalJobs),
            'hiringDate' => self::faker()->dateTimeBetween('-10 years', 'now'),
            'departureDate' => self::faker()->optional()->dateTimeBetween('-10years', 'now'),
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
