<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Post;
use App\Form\Type\PostType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Form\FormFactoryInterface;
use Datetime;

class PostController extends AbstractController
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
     * PostController constructor.
     * @param Security $security
     * @param FormFactoryInterface $formFactory
     */
    public function __construct(Security $security, FormFactoryInterface $formFactory){
        $this->security = $security;
        $this->formFactory = $formFactory;
    }

    /**
     * @Route("/posts")
     * @return Response
     */
    public function posts(): Response
    {
        return $this->render('posts/posts.html.twig', [
            'title' => "Posts!",
        ]);
    }

    /**
     * @Route("/posts/list")
     * @return JsonResponse
     */
    public function blogsList(): JsonResponse
    {
        $response = new JsonResponse();

        $posts = $this->getDoctrine()
            ->getRepository(Post::class)
            ->findAll();

        $serializer = $this->get('serializer');
        $data = $serializer->serialize($posts, 'json', ['groups' => 'serialize']);

        $response->setData($data);
        return $response;
    }

    /**
     * @Route("/admin/posts/createOrEdit", methods={"post"})
     * @param Request $request
     * @return JsonResponse
     */
    public function createOrEditPost(Request $request): JsonResponse
    {

        $response = new JsonResponse();

        $data = json_decode($request->getContent(), true);

        if(key_exists('id', $data) && !empty($data['id'])) {
            $post = $this->getDoctrine()
                ->getRepository(Post::class)
                ->find($data['id']);

            if($post->getAuthor() != $this->security->getUser()) {
                throw new Exception('User not authorized');
            }
        } else {
            $post = new Post();
            $post->setDate(new DateTime());
            $post->setAuthor($this->security->getUser());
        }


        $form = $this->formFactory->createNamed('', PostType::class, $post, ['csrf_protection' => false]);
        if (!$form->submit($data)->isValid()) {
            foreach ($form->getErrors() as $formError) {
                throw new Exception($formError->getMessage());
            }
        }


        $this->getDoctrine()->getRepository(Post::class)->save($post);

        $serializer = $this->get('serializer');
        $data = $serializer->serialize($post, 'json', ['groups' => 'serialize']);

        $response->setData($data);
        return $response;
    }
}