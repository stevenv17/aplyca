<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Form\Type\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Security;

class UserController extends AbstractController
{

    /**
     * @var Security
     */
    private Security $security;

    /**
     * @var FormFactoryInterface
     */
    private FormFactoryInterface $formFactory;

    /**
     * UserController constructor.
     * @param Security $security
     * @param FormFactoryInterface $formFactory
     */
    public function __construct(Security $security, FormFactoryInterface $formFactory){
        $this->security = $security;
        $this->formFactory = $formFactory;
    }

    /**
     * @Route("/current-user")
     */
    public function current_user()
    {
        $response = new JsonResponse();
        $user = $this->security->getUser();

        $serializer = $this->get('serializer');
        $data = $serializer->serialize($user, 'json', ['groups' => 'serialize']);

        $response->setData($data);
        return $response;
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

        $users = $this->getDoctrine()
            ->getRepository(User::class)
            ->findAll();

        $serializer = $this->get('serializer');
        $data = $serializer->serialize($users, 'json', ['groups' => 'serialize']);

        $response->setData($data);
        return $response;
    }

    /**
     * @Route("/admin/users/create", methods={"post"})
     * @param Request $request
     * @return JsonResponse
     */
    public function createContact(Request $request): JsonResponse
    {

        $response = new JsonResponse();

        $data = json_decode($request->getContent(), true);

        $user = new User();

        $form = $this->formFactory->createNamed('', UserType::class, $user, ['csrf_protection' => false]);
        if (!$form->submit($data)->isValid()) {
            foreach ($form->getErrors() as $formError) {
                throw new Exception($formError->getMessage());
            }
        }


        $this->getDoctrine()->getRepository(User::class)->save($user);

        $serializer = $this->get('serializer');
        $data = $serializer->serialize($user, 'json', ['groups' => 'serialize']);

        $response->setData($data);
        return $response;
    }
}