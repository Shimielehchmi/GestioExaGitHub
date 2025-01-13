<?php

namespace App\Controller\Admin;

use App\Entity\Enseignant;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class EnseignantCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Enseignant::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('nom', 'Nom'),
            TextField::new('prenom', 'Prénom'),
            TextField::new('cin', 'CIN'),
            CollectionField::new('modules', 'Modules Assignés')
            ->allowAdd()
            ->allowDelete(),
        ];
    }
}