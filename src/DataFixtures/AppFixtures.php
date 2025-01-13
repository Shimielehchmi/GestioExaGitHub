<?php

namespace App\DataFixtures;

use App\Entity\Enseignant;
use App\Entity\Etudient;
use App\Entity\Filiere;
use App\Entity\Module;
use App\Entity\Note;
use App\Entity\Role;
use App\Entity\Semestre;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Factory\EtudientFactory;
use App\Factory\EnseignantFactory;
use App\Factory\FiliereFactory;
use App\Factory\ModuleFactory;
use App\Factory\NoteFactory;
use App\Factory\SemestreFactory;
use App\Factory\UserFactory;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    /**
     * @var Generator
     */
    private Generator $faker;

    private UserPasswordHasherInterface $hasher;


    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->faker = Factory::create('fr_FR');
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        /*FiliereFactory::createMany(10);
        EnseignantFactory::createMany(10);
        EtudientFactory::createMany(10);
        SemestreFactory::createMany(10);
        ModuleFactory::createMany(10);
        NoteFactory::createMany(10);
        UserFactory::createMany(1);*/

        /*$admin = new User();
            $admin->setEmail('admin@shimi.fr')
                    ->setRoles(['ROLE_USER','ROLE_ADMIN'])
                    ->setRoles(['ROLE_ADMIN'])
                    ->setUsername('ADMIN')
                    ->setLocale('fr')
                    ->setIsVerified(1);
            $password = $this->hasher->hashPassword($admin, 'password');
            $admin->setPassword($password);

        $users[] = $admin;
        $manager->persist($admin);

        // Enseignant
        $enseignants = [];
        for($i = 1; $i <= 10; $i++){
            $enseignant = new Enseignant();
            $enseignant->setNom($this->faker->lastname())
                        ->setPrenom($this->faker->firstname())
                        ->setCin($this->faker->realText(10));
            $enseignants[] = $enseignant;
            $manager->persist($enseignant);
        }

        // Etudient
        $etudients = [];
        for($j = 0; $j <= 10; $j++){
            $etudient = new Etudient();
            $etudient->setNom($this->faker->lastname())
                    ->setPrenom($this->faker->firstName())
                    ->setCne($this->faker->realText(10))
                    ->setAdresse($this->faker->address());

            $etudients[] = $etudient;
            $manager->persist($etudient);
        }

        // Filiere
        $filiers = [];
        for($i = 1; $i <= 10; $i++){
            $filiere = new Filiere();
            $filiere->setNom($this->faker->lastName());

         $filiers[] = $filiere;
         $manager->persist($filiere);
        }

        // Semestre
        $semestres = [];
        for($i = 1; $i <= 10; $i++){
            $semestre = new Semestre();
            $semestre->setNom($this->faker->lastName());

            $semestres[] = $semestre;
            $manager->persist($semestre);
        }

        // Module

        $modules = [];
        for($i = 0; $i <= 10; $i++){
            $module = new Module();
            $module->setNom($this->faker->lastName())
                    ->setEnseignant($enseignants[mt_rand(0, count($enseignants) - 1)])
                    ->setFiliere($filiers[mt_rand(0, count($filiers) - 1)])
                    ->setSemestre($semestres[mt_rand(0, count($semestres) - 1)])
            ;

            $modules[] = $module;
            $manager->persist($module);
        }

        // Note
        $notes = [];
        for($i = 0; $i <= 10; $i++){
            $note = new Note();
            $note->setNote($this->faker->randomFloat())
                ->setObservation($this->faker->realText(50))
                ->setEtudient($etudients[mt_rand(0, count($etudients) - 1)])
                ->setModule($modules[mt_rand(0, count($modules) - 1)]);

            $notes[] = $note;

            $manager->persist($note);
        }
        $manager->flush();*/

        // Création des rôles
        $roleAdmin = new Role();
        $roleAdmin->setName('ROLE_ADMIN');
        $manager->persist($roleAdmin);

        $roleUser = new Role();
        $roleUser->setName('ROLE_USER');
        $manager->persist($roleUser);

        $roleEnseignant = new Role();
        $roleEnseignant->setName('ROLE_ENSEIGNANT');
        $manager->persist($roleEnseignant);

        $roleEtudiant = new Role();
        $roleEtudiant->setName('ROLE_ETUDIANT');
        $manager->persist($roleEtudiant);

        // Création des utilisateurs

        // Administrateur
        $admin = new User();
        $admin->setEmail('admin@example.com')
            ->setUsername('AdminUser')
            ->setLocale('fr')
            ->setIsVerified(true);
        $password = $this->hasher->hashPassword($admin, 'password');
        $admin->setPassword($password);
        $admin->addRole($roleAdmin);
        $manager->persist($admin);

        // Enseignants
        $enseignants = [];
        for ($i = 1; $i <= 5; $i++) {
            $enseignant = new Enseignant();
            $enseignant->setNom($this->faker->lastName())
                ->setPrenom($this->faker->firstName())
                ->setCin($this->faker->randomNumber(8, true));

            $enseignantUser = new User();
            $enseignantUser->setEmail("enseignant{$i}@example.com")
                ->setUsername("Enseignant{$i}")
                ->setLocale('fr')
                ->setIsVerified(true);
            $password = $this->hasher->hashPassword($enseignantUser, 'password');
            $enseignantUser->setPassword($password);
            $enseignantUser->addRole($roleEnseignant);

            $enseignants[] = $enseignant;
            $manager->persist($enseignant);
            $manager->persist($enseignantUser);
        }

        // Étudiants
        $etudiants = [];
        for ($i = 1; $i <= 10; $i++) {
            $etudiant = new Etudient();
            $etudiant->setNom($this->faker->lastName())
                ->setPrenom($this->faker->firstName())
                ->setCne($this->faker->randomNumber(8, true))
                ->setAdresse($this->faker->address());

            $etudiantUser = new User();
            $etudiantUser->setEmail("etudiant{$i}@example.com")
                ->setUsername("Etudiant{$i}")
                ->setLocale('fr')
                ->setIsVerified(true);
            $password = $this->hasher->hashPassword($etudiantUser, 'password');
            $etudiantUser->setPassword($password);
            $etudiantUser->addRole($roleEtudiant);

            $etudiants[] = $etudiant;
            $manager->persist($etudiant);
            $manager->persist($etudiantUser);
        }

        // Utilisateurs généraux
        for ($i = 1; $i <= 5; $i++) {
            $user = new User();
            $user->setEmail("user{$i}@example.com")
                ->setUsername("User{$i}")
                ->setLocale('fr')
                ->setIsVerified(true);
            $password = $this->hasher->hashPassword($user, 'password');
            $user->setPassword($password);
            $user->addRole($roleUser);
            $manager->persist($user);
        }

        // Création des filières
        $filieres = [];
        for ($i = 1; $i <= 5; $i++) {
            $filiere = new Filiere();
            $filiere->setNom("Filiere{$i}");
            $filieres[] = $filiere;
            $manager->persist($filiere);
        }

        // Création des semestres
        $semestres = [];
        for ($i = 1; $i <= 2; $i++) {
            $semestre = new Semestre();
            $semestre->setNom("Semestre{$i}");
            $semestres[] = $semestre;
            $manager->persist($semestre);
        }

        // Création des modules
        $modules = [];
        for ($i = 1; $i <= 10; $i++) {
            $module = new Module();
            $module->setNom("Module{$i}")
                ->setEnseignant($enseignants[mt_rand(0, count($enseignants) - 1)])
                ->setFiliere($filieres[mt_rand(0, count($filieres) - 1)])
                ->setSemestre($semestres[mt_rand(0, count($semestres) - 1)]);
            $modules[] = $module;
            $manager->persist($module);
        }

        // Création des notes
        for ($i = 1; $i <= 20; $i++) {
            $note = new Note();
            $note->setNote($this->faker->randomFloat(2, 0, 20))
                ->setObservation($this->faker->sentence())
                ->setEtudient($etudiants[mt_rand(0, count($etudiants) - 1)])
                ->setModule($modules[mt_rand(0, count($modules) - 1)]);
            $manager->persist($note);
        }

        // Enregistrement des données dans la base
        $manager->flush();
    }
}
