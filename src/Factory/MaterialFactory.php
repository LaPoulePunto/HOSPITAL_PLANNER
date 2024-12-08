<?php

namespace App\Factory;

use App\Entity\Material;
use App\Repository\MaterialRepository;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;
use Zenstruck\Foundry\Persistence\Proxy;
use Zenstruck\Foundry\Persistence\ProxyRepositoryDecorator;

/**
 * @extends PersistentProxyObjectFactory<Material>
 *
 * @method        Material|Proxy                              create(array|callable $attributes = [])
 * @method static Material|Proxy                              createOne(array $attributes = [])
 * @method static Material|Proxy                              find(object|array|mixed $criteria)
 * @method static Material|Proxy                              findOrCreate(array $attributes)
 * @method static Material|Proxy                              first(string $sortedField = 'id')
 * @method static Material|Proxy                              last(string $sortedField = 'id')
 * @method static Material|Proxy                              random(array $attributes = [])
 * @method static Material|Proxy                              randomOrCreate(array $attributes = [])
 * @method static MaterialRepository|ProxyRepositoryDecorator repository()
 * @method static Material[]|Proxy[]                          all()
 * @method static Material[]|Proxy[]                          createMany(int $number, array|callable $attributes = [])
 * @method static Material[]|Proxy[]                          createSequence(iterable|callable $sequence)
 * @method static Material[]|Proxy[]                          findBy(array $attributes)
 * @method static Material[]|Proxy[]                          randomRange(int $min, int $max, array $attributes = [])
 * @method static Material[]|Proxy[]                          randomSet(int $number, array $attributes = [])
 */
final class MaterialFactory extends PersistentProxyObjectFactory
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
        return Material::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        $material = [
            json_decode(
                file_get_contents(__DIR__.DIRECTORY_SEPARATOR.
                    DIRECTORY_SEPARATOR.'data'.
                    DIRECTORY_SEPARATOR.'Material.json'),
                true
            ),
        ];
        $randomIndex = random_int(0, count($material[0]) - 1);

        return [
            'label' => $material[0][$randomIndex]['label'],
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): MaterialFactory
    {
        return $this
            // ->afterInstantiate(function(Material $material): void {})
        ;
    }
}
