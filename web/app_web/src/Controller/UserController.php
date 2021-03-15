<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserController extends AbstractController
{

    //protected $manager;

    public function __construct(){
        //$this->manager = $this->getDoctrine()->getManager();
    }

    /**
     * @Route("/users")
    */
    public function users()
    {
        return $this->render('users/users.html.twig', [
            'Hellow' => "Welcome users!",
        ]);
    }

    /**
     * @Route("/users/list")
    */
    public function usersList()
    {
        $response = new JsonResponse();

        $response->setData(['name' => $this->getDoctrine()
        ->getRepository(User::class)
        ->find(1)->getName()]);
        
        return $response;
    }
}