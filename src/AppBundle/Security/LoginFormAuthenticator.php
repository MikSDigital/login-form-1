<?php

namespace AppBundle\Security;


use AppBundle\Form\LoginForm;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

class LoginFormAuthenticator extends AbstractFormLoginAuthenticator
{
    use TargetPathTrait;

    private $formFactory;
    private $em;
    private $router;

    public function __construct(FormFactoryInterface $formFactory, EntityManager $em, RouterInterface $router)
    {
        $this->formFactory = $formFactory;
        $this->em = $em;
        $this->router = $router;
    }

    public function getCredentials(Request $request)
    {
        if($request->attributes->get('_route') === 'security_login' && $request->isMethod('POST'))
        {
            $form = $this->formFactory->create(LoginForm::class);
            $form->handleRequest($request);

            $data = $form->getData();

            return $data;
        }

        return;
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $username = $credentials['_username'];
        return $this->em->getRepository('AppBundle:User')->findOneBy([
            'email' => $username
        ]);
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        $password = $credentials['_password'];

        if($password == 'password'){
            return true;
        }

        return false;
    }

    protected function getLoginUrl()
    {
        return $this->router->generate('security_login');
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        // if the user hits a secure page and start() was called, this was
        // the URL they were on, and probably where you want to redirect to
        $targetPath = $this->getTargetPath($request->getSession(), $providerKey);

        if (!$targetPath) {
            $targetPath = $this->router->generate('homepage');
        }

        return new RedirectResponse($targetPath);
    }
}