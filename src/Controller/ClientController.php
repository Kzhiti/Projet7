<?php
namespace App\Controller;

use App\Entity\User;
use App\Entity\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * Client Controller.
 * @Route("/api", name="api_")
 */
class ClientController extends AbstractController {



    /**
     * Create Client.
     * @Rest\Post("/clients")
     *
     * @return Response
     */
    public function addClient(Request $request) {
        $data = $request->getContent();
        $client = $this->get('serializer')->deserialize($data, 'App\Entity\Client', 'json');

        $em = $this->getDoctrine()->getManager();
        $em->persist($client);
        $em->flush();

        return new Response('', Response::HTTP_CREATED);
    }

    /**
     * Get Client.
     * @Rest\Get("/clients/{id}")
     *
     * @return Response
     */
    public function getClientById(Client $client) {
        $data = $this->get('serializer')->serialize($client, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * Get All Clients.
     * @Rest\Get("/clients")
     *
     * @return Response
     */
    public function getClients()
    {
        $repository = $this->getDoctrine()->getRepository(Client::class);
        $clients = $repository->findAll();
        $data = $this->get('serializer')->serialize($clients, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * Delete Client.
     * @Rest\Delete("/clients/{id}")
     *
     * @return Response
     */
    public function deleteClient(Client $client) {

        $em = $this->getDoctrine()->getManager();
        $em->remove($client);
        $em->flush();

        return new Response('', Response::HTTP_NO_CONTENT);
    }

    /**
     * Update Client.
     * @Rest\Put("/clients/{id}")
     *
     * @return Response
     */
    public function updateClient(Client $client, Request $request) {

        $data = $request->getContent();
        $client_update = $this->get('serializer')->deserialize($data, 'App\Entity\Client', 'json');

        $client->setName($client_update->getName());

        $em = $this->getDoctrine()->getManager();
        $em->persist($client);
        $em->flush();

        $response = new Response($data, Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * Update Client.
     * @Rest\Get("/clients/{id}/users")
     *
     * @return Response
     */
    public function getClientUsers(Client $client)
    {
        $data = $this->get('serializer')->serialize($client->getUsers(), 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

}
