<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class PostRepository extends EntityRepository
{

    /**
     * @param Post $post
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(Post $post)
    {
        if (!$this->_em->contains($post)) {
            $this->_em->persist($post);
        }

        $this->_em->flush();
    }
}
