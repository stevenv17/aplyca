<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Contact;
use App\Form\Type\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Form\FormFactoryInterface;
use Datetime;

class ContactController extends AbstractController
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
     * ContactController constructor.
     * @param Security $security
     * @param FormFactoryInterface $formFactory
     */
    public function __construct(Security $security, FormFactoryInterface $formFactory){
        $this->security = $security;
        $this->formFactory = $formFactory;
    }

    /**
     * @Route("/admin/contacts/create", methods={"post"})
     * @param Request $request
     * @return JsonResponse
     */
    public function createContact(Request $request): JsonResponse
    {

        $response = new JsonResponse();

        $data = json_decode($request->getContent(), true);

        $contact = new Contact();

        $form = $this->formFactory->createNamed('', ContactType::class, $contact, ['csrf_protection' => false]);
        if (!$form->submit($data)->isValid()) {
            foreach ($form->getErrors() as $formError) {
                throw new Exception($formError->getMessage());
            }
        }


        $this->getDoctrine()->getRepository(Contact::class)->save($contact);

        $serializer = $this->get('serializer');
        $data = $serializer->serialize($contact, 'json', ['groups' => 'serialize']);

        $response->setData($data);
        return $response;
    }
}