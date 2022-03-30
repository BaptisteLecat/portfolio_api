<?php

namespace App\Controller;

use App\Entity\User;
use Firebase\JWT\JWT;
use App\Repository\UserRepository;
use App\Security\JwtAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AuthController extends AbstractController
{
    private $security;
    private $em;

    public function __construct(Security $security, EntityManagerInterface $entityManager)
    {
        $this->security = $security;
        $this->em = $entityManager;
    }

    /**
     * @Route("api/auth", name="auth")
     */
    public function index(): Response
    {
        return $this->render('auth/index.html.twig', [
            'controller_name' => 'AuthController',
        ]);
    }

    /**
     * @Route("api/auth/register", name="register", methods={"POST"})
     */
    public function register(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $lastname = $request->get('lastname');
        $firstname = $request->get('firstname');
        $email = $request->get('email');
        $password = $request->get('password');
        if (!is_null($lastname) && !is_null($firstname) && !is_null($email) && !is_null($password)) {
            $repository = $this->getDoctrine()->getRepository(User::class);
            $user = $repository->findOneBy(['email' => $email]);
            if (is_null($user)) {
                $user = new User();
                $user->setPassword($encoder->encodePassword($user, $password));
                $user->setFirstname($firstname);
                $user->setLastName($lastname);
                $user->setEmail($email);
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
                return $this->json([
                    'user' => $user->getEmail()
                ], 201);
            } else {
                return $this->json([
                    'message' => "Cet identifiant existe déjà."
                ], 409);
            }
        } else {
            return $this->json([
                'message' => "Certains arguments sont manquants"
            ], 422);
        }
    }

    /**
     * @Route("api/auth/login", name="login", methods={"POST"})
     */
    public function login(Request $request, UserRepository $userRepository, UserPasswordEncoderInterface $encoder)
    {
        $emailParam = $request->get('email');
        if (!is_null($emailParam)) {
            $user = $userRepository->findOneBy([
                'email' => $request->get('email'),
            ]);
            if (!$user || !$encoder->isPasswordValid($user, $request->get('password'))) {
                return $this->json([
                    'message' => 'Identifiants incorrects.',
                ], 404);
            }
            $payload = [
                "user" => $user->getUserIdentifier(),
                "exp"  => (new \DateTime())->modify("+30 day")->getTimestamp(),
            ];


            $jwt = JWT::encode($payload, $this->getParameter('jwt_secret'), 'HS256');
            $user->setJwt($jwt);
            $this->em->persist($user);
            $this->em->flush();
        } else {
            $user = $this->getUser();
            if (!$user) {
                return $this->json([
                    'message' => 'Identifiants incorrects.',
                ], 404);
            }
        }
        return $this->json(["id" => $user->getId(), "lastname" => $user->getLastName(), "firstname" => $user->getFirstname(), "email" => $user->getEmail(), "roles" => $user->getRoles(), "jwt" => $user->getJwt()]);
    }
}
