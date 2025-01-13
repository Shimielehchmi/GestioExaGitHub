<?php
namespace App\EntityListeners;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserListener
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function prePersist(User $user)
    {
        $this->encodePassword($user);
    }

    /*public function preUpdate(User $user)
    {
        $this->encodePassword($user);
    }*/

    /**
     * encode password based on plain password
     * @param User $user
     */
    public function encodePassword(User $user)
    {
        if($user->getPassword() === null){
            return;
        }

        $user->setPassword(
            $this->hasher->hashPassword(
                $user,
                $user->getPassword()
            )
        );
        $user->setPassword(null);
    }
}