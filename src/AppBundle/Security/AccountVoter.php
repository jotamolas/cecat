<?php

namespace AppBundle\Security;


use AppBundle\Entity\Account;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;

class AccountVoter extends Voter {

   
    const VIEW = 'view';
    const EDIT = 'edit';
    const CREATE = 'create';
    const DELETE = 'delete';

    private $decisionManager;

    public function __construct(AccessDecisionManagerInterface $decisionManager) {
        $this->decisionManager = $decisionManager;
    }

    protected function supports($attribute, $subject) {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, array(self::VIEW, self::EDIT, self::CREATE, self::DELETE))) {
            return false;
        }

        
        if (!$subject instanceof Account) {
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

        
        /** @var Account $account */
        $account = $subject;

        if ($this->decisionManager->decide($token, ['ROLE_ADMIN'])) {
            return true;
        }

        switch ($attribute) {
            case self::VIEW:
                return $this->canView($account, $user);
            case self::EDIT:
                return $this->canEdit($account, $user);
            case self::CREATE:
                return $this->canCreate($account, $user);

            case self::DELETE:
                return $this->canDelete($account, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canView(Account $account, \FOS\UserBundle\Model\User $user) {
        
        return $account->getNotary() === $user ;
    }

    private function canEdit(Account $account, \FOS\UserBundle\Model\User $user) {
        return false;
    }

    private function canCreate(Account $account, \FOS\UserBundle\Model\User $user) {
        return false;
    }

    private function canDelete(Account $account, \FOS\UserBundle\Model\User $user) {
        return false;
    }

}
