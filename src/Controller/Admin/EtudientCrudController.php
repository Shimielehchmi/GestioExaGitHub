<?php

namespace App\Controller\Admin;

use App\Entity\Etudient;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class EtudientCrudController extends  AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Etudient::class;
    }
}