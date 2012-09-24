<?php

namespace Club\MatchBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * MatchRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MatchRepository extends EntityRepository
{
  public function getUnprocessed()
  {
    return $this->_em->createQueryBuilder()
      ->select('m')
      ->from('ClubMatchBundle:Match', 'm')
      ->where('m.processed = false')
      ->getQuery()
      ->getResult();
  }

  public function getRecentMatches(\Club\MatchBundle\Entity\League $league=null, $limit=10)
  {
    $qb = $this->_em->createQueryBuilder()
      ->select('m')
      ->from('ClubMatchBundle:Match', 'm')
      ->orderBy('m.id', 'DESC')
      ->setMaxResults($limit);

    return $qb
      ->getQuery()
      ->getResult();
  }

  public function getPaginator($results, $page)
  {
      $offset = ($page < 1) ? 1 : ($page-1)*$results;

      $dql = "SELECT m FROM ClubMatchBundle:Match m ORDER BY m.id DESC";
      $query = $this->_em->createQuery($dql)
          ->setFirstResult($offset)
          ->setMaxResults($results);

      return new \Doctrine\ORM\Tools\Pagination\Paginator($query, false);
  }
}
