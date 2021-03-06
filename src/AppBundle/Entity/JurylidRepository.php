<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;

/**
 * JurylidRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class JurylidRepository extends EntityRepository
{
    /**
     * @return mixed
     */
    public function getTotaalAantalIngeschrevenJuryleden()
    {
        $ingeschrevenJuryleden = $this->createQueryBuilder('u')
            ->select('count(u.id)')
            ->getQuery()
            ->getSingleScalarResult();
        return $ingeschrevenJuryleden;
    }

    /**
     * @param        $user
     * @param string $orderBy
     *
     * @return mixed
     */
    public function getIngeschrevenJuryleden($user, $orderBy = 'brevet')
    {
        $ingeschrevenJuryleden = $this->createQueryBuilder('u')
            ->select('count(u.id)')
            ->Where('u.user = :user')
            ->andWhere('u.isConfirmed = 1')
            ->orderBy('u.' . $orderBy)
            ->setParameters(
                [
                    'user' => $user,
                ]
            )
            ->getQuery()
            ->getSingleScalarResult();
        return $ingeschrevenJuryleden;
    }

    public function getIngeschrevenJuryledenPerUser($user, $orderBy = 'brevet')
    {
        $ingeschrevenJuryleden = $this->createQueryBuilder('u')
            ->Where('u.user = :user')
            ->orderBy('u.' . $orderBy)
            ->setParameters(
                [
                    'user' => $user,
                ]
            )
            ->getQuery()
            ->getResult();
        return $ingeschrevenJuryleden;
    }

    public function getAllJuryleden($orderBy = 'brevet')
    {
        $results = $this->createQueryBuilder('u')
            ->orderBy('u.' . $orderBy)
            ->getQuery()
            ->getResult();
        return $results;
    }
}
