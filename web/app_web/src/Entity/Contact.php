<?php


namespace App\Entity;

use App\Repository\ContactRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ContactRepository::class)
 * @ORM\Table(name="contacts")
 */
class Contact
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="id", type="integer")
     * @Groups({"serialize"})
     */
    private $id;

    /**
     * @ORM\Column(name="name", type="string", length=128)
     * @Groups({"serialize"})
     */
    private $name;

    /**
     * @ORM\Column(name="email", type="string", length=128)
     * @Groups({"serialize"})
     */
    private $email;

    /**
     * @ORM\Column(name="message", type="string")
     * @Groups({"serialize"})
     */
    private $message;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message): void
    {
        $this->message = $message;
    }



}