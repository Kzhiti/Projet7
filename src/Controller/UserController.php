<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class UserController extends AbstractController {

    public function register(Request $request) {
        $data = $request->getContent();
        $user = $this->get('jms_serializer')->deserialize($data, 'App\Entity\User', 'json');

    }
}