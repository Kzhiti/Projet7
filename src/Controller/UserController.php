<?php
namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Client;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\ConstraintViolationList;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * User Controller.
 * @Route("/api", name="api_")
 */
class UserController extends AbstractController {

    private UserPasswordHasherInterface $encoder;

    public function __construct(UserPasswordHasherInterface $encoder) {
        $this->encoder = $encoder;
    }

    /**
     * Create User.
     * @Rest\Post("/users")
     *
     * @return Response
     */
    public function register(Request $request) {
        $client = $this->getDoctrine()->getRepository(Client::class)->find(7);
        $data = $request->getContent();
        $user = $this->get('serializer')->deserialize($data, 'App\Entity\User', 'json');
        $passHash = $this->encoder->hashPassword($user, $user->getPassword());
        $user->setClient($client);
        $user->setRoles(['ROLE_ADMIN']);
        $user->setPassword($passHash);

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        return new Response('', Response::HTTP_CREATED);
    }

    /**
     * Get User.
     * @Rest\Get("/users/{id}")
     *
     * @return Response
     */
    public function getUserById(User $user) {
        $data = $this->get('serializer')->serialize($user, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * Get All Users.
     * @Rest\Get("/users")
     *
     * @return Response
     */
    public function getUsers()
    {
        $repository = $this->getDoctrine()->getRepository(User::class);
        $users = $repository->findAll();
        $data = $this->get('serializer')->serialize($users, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * Delete User.
     * @Rest\Delete("/users/{id}")
     *
     * @return Response
     */
    public function deleteUser(User $user) {

        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();

        return new Response('', Response::HTTP_NO_CONTENT);
    }

    /**
     * Update User.
     * @Rest\Put("/users/{id}")
     *
     * @return Response
     */
    public function updateUser(User $user, Request $request) {

        $data = $request->getContent();
        $user_update = $this->get('serializer')->deserialize($data, 'App\Entity\User', 'json');

        $passHash = $this->encoder->hashPassword($user_update, $user_update->getPassword());

        $user->setUsername($user_update->getUsername());
        $user->setPassword($passHash);

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        $response = new Response($data, Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}