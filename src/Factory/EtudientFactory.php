<?php

namespace App\Factory;

use App\Entity\Etudient;
use App\Repository\EtudientRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Etudient>
 *
 * @method static Etudient|Proxy createOne(array $attributes = [])
 * @method static Etudient[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Etudient[]|Proxy[] createSequence(array|callable $sequence)
 * @method static Etudient|Proxy find(object|array|mixed $criteria)
 * @method static Etudient|Proxy findOrCreate(array $attributes)
 * @method static Etudient|Proxy first(string $sortedField = 'id')
 * @method static Etudient|Proxy last(string $sortedField = 'id')
 * @method static Etudient|Proxy random(array $attributes = [])
 * @method static Etudient|Proxy randomOrCreate(array $attributes = [])
 * @method static Etudient[]|Proxy[] all()
 * @method static Etudient[]|Proxy[] findBy(array $attributes)
 * @method static Etudient[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Etudient[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static EtudientRepository|RepositoryProxy repository()
 * @method Etudient|Proxy create(array|callable $attributes = [])
 */
final class EtudientFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();

        // TODO inject services if required (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services)
    }

    protected function getDefaults(): array
    {
        return [
            // TODO add your default values here (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories)
            'nom' => self::faker()->lastName(),
            'prenom' => self::faker()->firstName(),
            'adresse' => self::faker()->address(),
            'cne' => self::faker()->realText(10),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Etudient $etudient): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Etudient::class;
    }
}
