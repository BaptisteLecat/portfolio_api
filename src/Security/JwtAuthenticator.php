<?php

namespace App\Security;

use App\Entity\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;

class JwtAuthenticator extends AbstractGuardAuthenticator
{
    private $em;
    private $params;

    public function __construct(EntityManagerInterface $em, ContainerBagInterface $params)
    {
        $this->em = $em;
        $this->params = $params;
    }

    /**
     * Called when authentication is needed, but it's not sent
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        $data = [
            'message' => 'Authentification requise'
        ];
        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }

    /**
     * This method checks whether the current request supports the authentication or not.
     */
    public function supports(Request $request)
    {
        return $request->headers->has('Authorization');
    }

    /**
     * This method returns the value of the Authorization header which is the token we return when user login.
     */
    public function getCredentials(Request $request)
    {
        return $request->headers->get('Authorization');
    }

    /**
     * This method is responsible to validate JWT Token and authenticate the user by the credentials's
     * value which is returned from the getCredential method
     * and it must return a User entity object or AuthenticationException.
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        try {
            $credentials = str_replace('Bearer ', '', $credentials);
            $jwt = JWT::decode(
                $credentials,
                new Key($this->params->get('jwt_secret'), 'HS256')
            );
            return $this->em->getRepository(User::class)
                ->findOneBy([
                    'email' => $jwt->user,
                ]);
        } catch (\Exception $exception) {
            throw new AuthenticationException($exception->getMessage());
        }
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        $success = false;
        $credentials = str_replace('Bearer ', '', $credentials);
        $jwt = JWT::decode(
            $credentials,
            new Key($this->params->get('jwt_secret'), 'HS256')
        );
        $user = $this->em->getRepository(User::class)
            ->findOneBy([
                'email' => $jwt->user,
            ]);
        if (!is_null($user)) {
            if ($user->getJwt() == $credentials) {
                $success = true;
            }
        }

        return $success;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $message = $exception->getMessage();
        if ($exception instanceof BadCredentialsException) {
            $message = "Ce token n'est plus valide";
        }
        return new JsonResponse([
            'message' => $message
        ], Response::HTTP_UNAUTHORIZED);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $providerKey)
    {
        return;
    }

    public function supportsRememberMe()
    {
        return false;
    }
}
