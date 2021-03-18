<?php


namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use DateTime;

/**
 * @ORM\Entity(repositoryClass=PostRepository::class)
 * @ORM\Table(name="posts")
 */
class Post
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="id", type="integer")
     * @Groups({"serialize"})
     */
    private $id;

    /**
     * @ORM\Column(name="title", type="string", length=128)
     * @Groups({"serialize"})
     */
    private $title;

    /**
     * @ORM\Column(name="description", type="string")
     * @Groups({"serialize"})
     */
    private $description;


    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(name="author", referencedColumnName="id")
     * @Groups({"serialize"})
     */
    private $author;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="date", type="date")
     * @Groups({"serialize"})
     */
    protected $date;

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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @return User
     */
    public function getAuthor(): ?User
    {
        return $this->author;
    }

    /**
     * @param User $author
     */
    public function setAuthor(User $author): void
    {
        $this->author = $author;
    }

    /**
     * @return DateTime
     */
    public function getDate(): DateTime
    {
        return $this->date;
    }

    /**
     * @param DateTime $date
     */
    public function setDate(DateTime $date): void
    {
        $this->date = $date;
    }

}