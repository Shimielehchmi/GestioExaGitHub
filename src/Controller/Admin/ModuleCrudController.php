<?php

namespace App\Controller\Admin;

use App\Entity\Module;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ModuleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Module::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('nom', 'Nom du Module'),
            AssociationField::new('enseignant', 'Enseignant')
                ->setRequired(true),
            AssociationField::new('filiere', 'Filière')
                ->setRequired(true),
            AssociationField::new('semestre', 'Semestre')
                ->setRequired(true),
        ];
    }
}