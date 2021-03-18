<?php

namespace App\Repository;

use App\Entity\Contact;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class ContactRepository extends EntityRepository
{

    /**
     * @param Contact $contact
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(Contact $contact)
    {
        if (!$this->_em->contains($contact)) {
            $this->_em->persist($contact);
        }

        $this->_em->flush();
    }
}
