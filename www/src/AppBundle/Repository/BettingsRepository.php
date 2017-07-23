<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Bettings;
use Doctrine\ORM\EntityRepository;

/**
 * Class BettingsRepository
 *
 * @package AppBundle\Repository
 */
class BettingsRepository extends EntityRepository
{
    /**
     * Find bet or create new
     *
     * @param array $params
     *
     * @return Bettings
     */
    public function findBetForBetForm($params)
    {
        $bet = $this->createQueryBuilder('b')
            ->where('b.gameId = :game_id')
            ->setParameter('game_id', $params['game_id'])
            ->andWhere('b.status = :status')
            ->setParameter('status', Bettings::STATUS_OFFERED)
            ->getQuery()
            ->getOneOrNullResult();

        if (!$bet instanceof Bettings) {
            $bet = new Bettings();
        }

        return $bet;
    }

    /**
     * Find bet for edit score
     *
     * @param array $params
     *
     * @return Bettings
     */
    public function findBetForScoreForm($params)
    {
        return $this->createQueryBuilder('b')
            ->where('b.id = :id')
            ->setParameter('id', $params['bet_id'])
            ->andWhere('b.originGuid = :player_id OR b.opponentGuid = :player_id')
            ->setParameter('player_id', $params['player_id'])
            ->andWhere('b.status = :status')
            ->setParameter('status', Bettings::STATUS_ACCEPTED)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Check winner (for cron)
     */
    public function checkWinner()
    {
        $timestamp = (new \DateTime('now'))->getTimestamp();

        $this->createQueryBuilder('b')
            ->update()
            ->set('b.winner', '(CASE WHEN b.originScore > b.opponentScore THEN 1 ELSE (CASE WHEN b.originScore < b.opponentScore THEN -1 ELSE 0 END) END)')
            ->set('b.status', Bettings::STATUS_FINISHED)
            ->set('b.end', $timestamp)
            ->set('b.updatedAt', $timestamp)
            ->where('b.status = :status')
            ->setParameter('status', Bettings::STATUS_ACCEPTED)
            ->andWhere('b.start < :date')
            ->setParameter('date', $timestamp - 10 * 60)
            ->getQuery()
            ->execute();
    }
}