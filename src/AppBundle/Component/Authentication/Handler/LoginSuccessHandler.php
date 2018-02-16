<?php

namespace AppBundle\Component\Authentication\Handler;

use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Router;

class LoginSuccessHandler implements AuthenticationSuccessHandlerInterface {

    protected $router;
    protected $security;

    public function __construct(Router $router, AuthorizationChecker $security) {
        $this->router = $router;
        $this->security = $security;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token) {

        
       
        if ($this->security->isGranted('ROLE_ADMIN')) {
            $response = new RedirectResponse($this->router->generate('cecat_admin_page'));
        } elseif ($this->security->isGranted('ROLE_NOTARIO')) {
            $response = new RedirectResponse($this->router->generate('cecat_front_page'));
        } elseif ($this->security->isGranted('ROLE_ACCOUNTANT')){
            $response = new RedirectResponse($this->router->generate('cecat_accountant_page'));
        }

        return $response;
    }

}
