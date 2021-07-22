<?php
namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Client;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController {

    /**
     * @Route("/users", name="add_user", methods={"POST"})
     */
    public function register(Request $request) {
        $client = $this->getDoctrine()->getRepository(Client::class)->find(5);
        $data = $request->getContent();
        $user = $this->get('jms_serializer')->deserialize($data, 'App\Entity\User', 'json');
        $user->setClient($client);

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        return new Response('', Response::HTTP_CREATED);
    }

    /**
     * @Route("/users/{id}", name="get_user")
     */
    public function getUserById(User $user) {
        $data = $this->get('jms_serializer')->serialize($user, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/users", name="user_list", methods={"GET"})
     */
    public function getUsers()
    {
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();
        $data = $this->get('jms_serializer')->serialize($users, 'json', SerializationContext::create()->setGroups(array('detail')));

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/users/{id}", name="delete_user", methods={"DELETE"})
     */
    public function deleteUser(Request $request) {
        $data = $request->getContent();
        $user = $this->get('jms_serializer')->deserialize($data, 'App\Entity\User', 'json');

        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();

        return new Response('', Response::HTTP_NO_CONTENT);
    }
}