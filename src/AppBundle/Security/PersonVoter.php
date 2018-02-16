<?php

namespace AppBundle\Security;

use AppBundle\Entity\Person;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;

class PersonVoter extends Voter {

    const VIEW = 'view';
    const EDIT = 'edit';
    const CREATE = 'create';
    const DELETE = 'delete';
    const CHANGE_PASSWORD = 'change_password';

    private $decisionManager;

    public function __construct(AccessDecisionManagerInterface $decisionManager) {
        $this->decisionManager = $decisionManager;
    }

    protected function supports($attribute, $subject) {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, array(self::VIEW, self::EDIT, self::CREATE, self::DELETE, self::CHANGE_PASSWORD))) {
            return false;
        }


        if (!$subject instanceof Person) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token) {

        $user = $token->getUser();

        if (!$user instanceof \FOS\UserBundle\Model\User) {
            // the user must be logged in; if not, deny access
            return false;
        }



        /** @var Person $person */
        $person = $subject;


        if ($this->decisionManager->decide($token, ['ROLE_ADMIN'])) {
            return true;
        }

        switch ($attribute) {
            
            case self::VIEW:
                return $this->canView($person, $user);
                
            case self::EDIT:
                return $this->canEdit($person, $user);
                
            case self::CREATE:
                return $this->canCreate($person, $user);
                
            case self::DELETE:
                return $this->canDelete($person, $user);
                
            case self::CHANGE_PASSWORD:
                return $this->canChangePassword($person, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canView(Person $person, \FOS\UserBundle\Model\User $user) {
        return false;
    }

    private function canEdit(Person $person, \FOS\UserBundle\Model\User $user) {
        return false;
    }

    private function canChangePassword(Person $person, \FOS\UserBundle\Model\User $user) {
        return $person === $user;
    }

    private function canCreate(Person $person, \FOS\UserBundle\Model\User $user) {
        return false;
    }

    private function canDelete(Person $person, \FOS\UserBundle\Model\User $user) {
        return false;
    }

}
