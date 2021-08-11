<?php
namespace App\Controller;

use App\Entity\Product;
use App\Form\UserFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * Product Controller.
 * @Route("/api", name="api_")
 */
class ProductController extends AbstractController {

    /**
     * Create product.
     * @Rest\Post("/products")
     *
     * @return Response
     */
    public function addProduct(Request $request) {
        $data = $request->getContent();
        $product = $this->get('serializer')->deserialize($data, 'App\Entity\Product', 'json');

        $em = $this->getDoctrine()->getManager();
        $em->persist($product);
        $em->flush();

        return new Response('', Response::HTTP_CREATED);
    }

    /**
     * Get Product.
     * @Rest\Get("/products/{id}")
     *
     * @return Response
     */
    public function getProductById(Product $product) {
        $data = $this->get('serializer')->serialize($product, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * Get All Products.
     * @Rest\Get("/products")
     *
     * @return Response
     */
    public function getProducts()
    {
        $repository = $this->getDoctrine()->getRepository(Product::class);
        $products = $repository->findAll();
        $data = $this->get('serializer')->serialize($products, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * Delete Product.
     * @Rest\Delete("/products/{id}")
     *
     * @return Response
     */
    public function deleteUser(Product $product) {

        $em = $this->getDoctrine()->getManager();
        $em->remove($product);
        $em->flush();

        return new Response('', Response::HTTP_NO_CONTENT);
    }

    /**
     * Update Product.
     * @Rest\Put("/products/{id}")
     *
     * @return Response
     */
    public function updateUser(Product $product, Request $request) {

        $data = $request->getContent();
        $product_update = $this->get('serializer')->deserialize($data, 'App\Entity\Product', 'json');

        $product->setName($product_update->getName());
        $product->setPrice($product_update->getPrice());
        $product->setDescription($product_update->getDescription());
        $product->setBrand($product_update->getBrand());

        $em = $this->getDoctrine()->getManager();
        $em->persist($product);
        $em->flush();

        $response = new Response($data, Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}