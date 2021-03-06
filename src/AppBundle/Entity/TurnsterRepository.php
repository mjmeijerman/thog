<?php

namespace AppBundle\Entity;

use Doctrine\DBAL\DBALException;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use PDO;

class TurnsterRepository extends EntityRepository
{
    public function getBezettePlekken()
    {
        $bezettePlekken = $this->createQueryBuilder('u')
            ->select('count(u.id)')
            ->where('u.afgemeld = 0')
            ->andWhere('u.wachtlijst = 0')
            ->getQuery()
            ->getSingleScalarResult();
        return $bezettePlekken;
    }

    public function getAantalWachtlijstPlekken()
    {
        $bezettePlekken = $this->createQueryBuilder('u')
            ->select('count(u.id)')
            ->where('u.afgemeld = 0')
            ->andWhere('u.wachtlijst = 1')
            ->getQuery()
            ->getSingleScalarResult();
        return $bezettePlekken;
    }

    public function getAantalAfgemeldeTurnsters($user)
    {
        $afgemeldeTurnsters = $this->createQueryBuilder('u')
            ->select('count(u.id)')
            ->where('u.afgemeld = 1')
            ->andWhere('u.user = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getSingleScalarResult();
        return $afgemeldeTurnsters;
    }

    public function getAantalTurnstersPerNiveau($geboortejaar, $niveau)
    {
        $turnsters = $this->createQueryBuilder('u')
            ->select('count(u.id)')
            ->where('u.afgemeld = 0')
            ->andWhere('u.wachtlijst = 0')
            ->andWhere('u.geboortejaar = :geboortejaar')
            ->andWhere('u.niveau = :niveau')
            ->setParameters(
                [
                    'geboortejaar' => $geboortejaar,
                    'niveau'       => $niveau,
                ]
            )
            ->getQuery()
            ->getSingleScalarResult();
        return $turnsters;
    }

    public function getAantalTurnstersWachtlijstPerNiveau($geboortejaar, $niveau)
    {
        $turnsters = $this->createQueryBuilder('u')
            ->select('count(u.id)')
            ->where('u.afgemeld = 0')
            ->andWhere('u.wachtlijst = 1')
            ->andWhere('u.geboortejaar = :geboortejaar')
            ->andWhere('u.niveau = :niveau')
            ->setParameters(
                [
                    'geboortejaar' => $geboortejaar,
                    'niveau'       => $niveau,
                ]
            )
            ->getQuery()
            ->getSingleScalarResult();
        return $turnsters;
    }

    public function getIngeschrevenTurnsters($user)
    {
        $ingeschrevenTurnsters = $this->createQueryBuilder('u')
            ->select('count(u.id)')
            ->where('u.afgemeld = 0')
            ->andWhere('u.wachtlijst = 0')
            ->andWhere('u.user = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getSingleScalarResult();
        return $ingeschrevenTurnsters;
    }

    public function getWachtlijstTurnsters($user)
    {
        $ingeschrevenTurnsters = $this->createQueryBuilder('u')
            ->select('count(u.id)')
            ->where('u.afgemeld = 0')
            ->andWhere('u.wachtlijst = 1')
            ->andWhere('u.user = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getSingleScalarResult();
        return $ingeschrevenTurnsters;
    }

    public function getAfgemeldeTurnsters($user)
    {
        $ingeschrevenTurnsters = $this->createQueryBuilder('u')
            ->select('count(u.id)')
            ->where('u.afgemeld = 1')
            ->andWhere('u.user = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getSingleScalarResult();
        return $ingeschrevenTurnsters;
    }

    public function getIngeschrevenTurnstersForUser($user)
    {
        $results = $this->createQueryBuilder('u')
            ->where('u.afgemeld = 0')
            ->andWhere('u.wachtlijst = 0')
            ->andWhere('u.user = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
        return $results;
    }

    public function getWachtlijstTurnstersForUser($user)
    {
        $results = $this->createQueryBuilder('u')
            ->where('u.afgemeld = 0')
            ->andWhere('u.wachtlijst = 1')
            ->andWhere('u.user = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
        return $results;
    }

    public function getAfgemeldTurnstersForUser($user)
    {
        $results = $this->createQueryBuilder('u')
            ->where('u.afgemeld = 1')
            ->andWhere('u.user = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
        return $results;
    }

    public function getIngeschrevenTurnstersCatNiveau($categorie, $niveau)
    {
        $ingeschrevenTurnsters = $this->createQueryBuilder('u')
            ->where('u.afgemeld = 0')
            ->andWhere('u.wachtlijst = 0')
            ->andWhere('u.categorie = :categorie')
            ->andWhere('u.niveau = :niveau')
            ->orderBy('u.user')
            ->setParameters(
                [
                    'niveau'    => $niveau,
                    'categorie' => $categorie,
                ]
            )
            ->getQuery()
            ->getResult();
        return $ingeschrevenTurnsters;
    }

    public function getWachtlijstTurnstersCatNiveau($categorie, $niveau)
    {
        $ingeschrevenTurnsters = $this->createQueryBuilder('u')
            ->where('u.afgemeld = 0')
            ->andWhere('u.wachtlijst = 1')
            ->andWhere('u.categorie = :categorie')
            ->andWhere('u.niveau = :niveau')
            ->orderBy('u.id')
            ->setParameters(
                [
                    'niveau'    => $niveau,
                    'categorie' => $categorie,
                ]
            )
            ->getQuery()
            ->getResult();
        return $ingeschrevenTurnsters;
    }

    public function getGereserveerdePlekken()
    {
        $gereserveerdePlekken = $this->createQueryBuilder('u')
            ->where('u.afgemeld = 0')
            ->andWhere('u.expirationDate IS NOT NULL')
            ->getQuery()
            ->getResult();
        return $gereserveerdePlekken;
    }

    public function getWachtlijstPlekken($limit)
    {
        $result = $this->createQueryBuilder('u')
            ->where('u.afgemeld = 0')
            ->andWhere('u.wachtlijst = 1')
            ->orderBy('u.id')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
        return $result;
    }

    public function getTijdVol()
    {
        $result = $this->createQueryBuilder('u')
            ->select('u.creationDate')
            ->where('u.wachtlijst = 0')
            ->orderBy('u.id', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult();
        return $result;
    }

    public function getDistinctCatNiv($userId)
    {
        $results = $this->createQueryBuilder('cc')
            ->join('cc.user', 'u')
            ->select('cc.categorie, cc.niveau')
            ->where('u.id = :userId')
            ->setParameter('userId', $userId)
            ->distinct()
            ->getQuery()
            ->getResult();
        return $results;
    }

    public function getTurnstersOrderedByDayAndVereniging()
    {
        $connection = $this->getEntityManager()->getConnection();

        $sql = <<<EOQ
SELECT
  t.id,
  t.categorie,
  t.niveau,
  t.voornaam,
  t.achternaam,
  v.naam as vereniging_naam,
  v.plaats as vereniging_plaats,
  s.wedstrijdnummer
FROM
  turnster t
JOIN
  scores s ON t.score_id = s.id
JOIN
  user u ON t.user_id = u.id
JOIN
  vereniging v ON u.vereniging_id = v.id
WHERE
  t.wachtlijst = 0
AND
  t.afgemeld = 0
ORDER BY
  s.wedstrijddag, t.user_id, s.wedstrijdronde, s.wedstrijdnummer
EOQ;

        $stmt = $connection->executeQuery($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
