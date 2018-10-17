<?php

namespace AppBundle\Security;

use AppBundle\Exception\AccountDeletedException;
use AppBundle\Security\User as AppUser;
use Symfony\Component\Security\Core\Exception\AccountExpiredException;
//use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class UserChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user)
    {              
        
        if(!$user->getStatus()){
            throw new AuthenticationException('You must be a customer in order to login');
            
//            throw new UnsupportedUserException(
//                sprintf('Instances of "%s" are not supported.', get_class($user))
//            );            
        }        

        
        if (!$user instanceof AppUser) {
            return;
        }

        // user is deleted, show a generic Account Not Found message.
        if ($user->isDeleted()) {
            throw new AccountDeletedException('...');
        }
    }

    public function checkPostAuth(UserInterface $user)
    {
        
        if (!$user instanceof AppUser) {
            return;
        }

        // user account is expired, the user may be notified
        if ($user->isExpired()) {
            throw new AccountExpiredException('...');
        }
    }
}