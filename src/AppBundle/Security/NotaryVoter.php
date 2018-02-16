<?php

namespace AppBundle\Security;

use AppBundle\Entity\Notary;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;

class NotaryVoter extends Voter {

    const VIEW = 'view';
    const EDIT = 'edit';
    const CREATE = 'create';
    const DELETE = 'delete';
    const LIST_T = 'list';

    private $decisionManager;

    public function __construct(AccessDecisionManagerInterface $decisionManager) {
        $this->decisionManager = $decisionManager;
    }

    protected function supports($attribute, $subject) {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, array(self::VIEW, self::EDIT, self::CREATE, self::DELETE, self::LIST_T))) {
            return false;
        }


        if (!$subject instanceof Notary) {
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



        /** @var Notary $notary */
        $notary = $subject;


        if ($this->decisionManager->decide($token, ['ROLE_SUPER_ADMIN'])) {
            return true;
        }

        switch ($attribute) {
            case self::VIEW:
                return $this->canView($notary, $user);
            case self::EDIT:
                return $this->canEdit($notary, $user);
            case self::CREATE:
                return $this->canCreate($notary, $user);
            case self::DELETE:
                return $this->canDelete($notary, $user);
            case self::LIST_T:
                return $this->canList($notary, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canView(Notary $notary, \FOS\UserBundle\Model\User $user) {
        return in_array('ROLE_ADMIN', $user->getRoles());
    }

    private function canEdit(Notary $notary, \FOS\UserBundle\Model\User $user) {
        return in_array('ROLE_ADMIN', $user->getRoles());
    }

    private function canList(Notary $notary, \FOS\UserBundle\Model\User $user) {
        return in_array('ROLE_ADMIN', $user->getRoles());
    }

    private function canCreate(Notary $notary, \FOS\UserBundle\Model\User $user) {
        return false;
    }

    private function canDelete(Notary $notary, \FOS\UserBundle\Model\User $user) {
        return false;
    }

}
