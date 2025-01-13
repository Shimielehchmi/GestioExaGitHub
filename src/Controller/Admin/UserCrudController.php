<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserCrudController extends AbstractCrudController
{
    private UserPasswordHasherInterface $passwordHasher;
    public function __construct(
       UserPasswordHasherInterface $passwordHasher,
    )
    {
        $this->passwordHasher = $passwordHasher;
    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $passwordField = TextField::new('password', 'Mot de passe')
                ->setFormTypeOption('mapped', false)
                ->setRequired($pageName === 'new');
            //dd($passwordField);
        return [
            EmailField::new('email', 'Email'),
            TextField::new('username', 'Username'),
            BooleanField::new('is_verified', 'Vérifié'),
            TextField::new('locale', 'Langue'),
            AssociationField::new('roles', 'Rôles')
                ->setHelp('Ajoutez ou supprimez les rôles dynamiques.')
                ->setFormTypeOption('by_reference', false)
                ->setFormTypeOption('multiple', true),
            $passwordField,
            AssociationField::new('enseignant', 'Enseignant Lié')
                ->setHelp('Lien vers un enseignant existant'),
            AssociationField::new('etudient', 'Étudiant Lié')
                ->setHelp('Lien vers un etudiant existant'),
        ];
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {

        if (!$entityInstance instanceof User) {
            return;
        }

        $plainPassword = $this->getContext()->getRequest()->request->all('User')['password'] ?? null;
        if ($plainPassword) {
            $hashedPassword = $this->passwordHasher->hashPassword($entityInstance, $plainPassword);
            $entityInstance->setPassword($hashedPassword);
        }

        parent::persistEntity($entityManager, $entityInstance);
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!$entityInstance instanceof User) {
            return;
        }
        dump($entityInstance->getRoles());
        exit;
        $plainPassword = $this->getContext()->getRequest()->request->all('User')['password'] ?? null;
        if ($plainPassword) {
            $hashedPassword = $this->passwordHasher->hashPassword($entityInstance, $plainPassword);
            $entityInstance->setPassword($hashedPassword);
        }



        parent::updateEntity($entityManager, $entityInstance);
    }
}