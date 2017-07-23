<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Bettings
 *
 * @ORM\Table(name="bettings")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BettingsRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Bettings
{
    const STATUS_OFFERED = 1;
    const STATUS_ACCEPTED = 2;
    const STATUS_FINISHED = 3;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="origin_guid", type="string", length=36, nullable=false)
     */
    private $originGuid;

    /**
     * @var string
     *
     * @ORM\Column(name="opponent_guid", type="string", length=36, nullable=true)
     */
    private $opponentGuid;

    /**
     * @var integer
     *
     * @ORM\Column(name="game_id", type="integer", nullable=false, options={"default":0})
     */
    private $gameId;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer", nullable=false, options={"default":0})
     */
    private $status;

    /**
     * @var integer
     *
     * @ORM\Column(name="amount", type="integer", nullable=false, options={"default":0})
     */
    private $amount;

    /**
     * @var integer
     *
     * @ORM\Column(name="winner", type="integer", nullable=true)
     */
    private $winner;

    /**
     * @var integer
     *
     * @ORM\Column(name="origin_score", type="integer", nullable=true)
     */
    private $originScore;

    /**
     * @var integer
     *
     * @ORM\Column(name="opponent_score", type="integer", nullable=true)
     */
    private $opponentScore;

    /**
     * @var integer
     *
     * @ORM\Column(name="start", type="integer", nullable=false, options={"default":0})
     */
    private $start;

    /**
     * @var integer
     *
     * @ORM\Column(name="end", type="integer", nullable=false, options={"default":0})
     */
    private $end;

    /**
     * @var integer
     *
     * @ORM\Column(name="created_at", type="integer", nullable=false, options={"default":0})
     */
    private $createdAt;

    /**
     * @var integer
     *
     * @ORM\Column(name="updated_at", type="integer", nullable=false, options={"default":0})
     */
    private $updatedAt;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersist(){
        $this->status = self::STATUS_OFFERED;
        $this->start = $this->end = 0;
        $this->createdAt = $this->updatedAt = (new \DateTime('now'))->getTimestamp();
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdate(){
        $this->updatedAt = (new \DateTime('now'))->getTimestamp();
    }

    /**
     * Set originGuid
     *
     * @param string $originGuid
     *
     * @return Bettings
     */
    public function setOriginGuid($originGuid)
    {
        $this->originGuid = $originGuid;

        return $this;
    }

    /**
     * Get originGuid
     *
     * @return string
     */
    public function getOriginGuid()
    {
        return $this->originGuid;
    }

    /**
     * Set opponentGuid
     *
     * @param string $opponentGuid
     *
     * @return Bettings
     */
    public function setOpponentGuid($opponentGuid)
    {
        $this->opponentGuid = $opponentGuid;

        return $this;
    }

    /**
     * Get opponentGuid
     *
     * @return string
     */
    public function getOpponentGuid()
    {
        return $this->opponentGuid;
    }

    /**
     * Set gameId
     *
     * @param integer $gameId
     *
     * @return Bettings
     */
    public function setGameId($gameId)
    {
        $this->gameId = $gameId;

        return $this;
    }

    /**
     * Get gameId
     *
     * @return integer
     */
    public function getGameId()
    {
        return $this->gameId;
    }

    /**
     * Set status
     *
     * @param boolean $status
     *
     * @return Bettings
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set start
     *
     * @param integer $start
     *
     * @return Bettings
     */
    public function setStart($start)
    {
        $this->start = $start;

        return $this;
    }

    /**
     * Get start
     *
     * @return integer
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Set end
     *
     * @param integer $end
     *
     * @return Bettings
     */
    public function setEnd($end)
    {
        $this->end = $end;

        return $this;
    }

    /**
     * Get end
     *
     * @return integer
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * Set amount
     *
     * @param integer $amount
     *
     * @return Bettings
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return integer
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set winner
     *
     * @param boolean $winner
     *
     * @return Bettings
     */
    public function setWinner($winner)
    {
        $this->winner = $winner;

        return $this;
    }

    /**
     * Get winner
     *
     * @return boolean
     */
    public function getWinner()
    {
        return $this->winner;
    }

    /**
     * Set originScore
     *
     * @param integer $originScore
     *
     * @return Bettings
     */
    public function setOriginScore($originScore)
    {
        $this->originScore = $originScore;

        return $this;
    }

    /**
     * Get originScore
     *
     * @return integer
     */
    public function getOriginScore()
    {
        return $this->originScore;
    }

    /**
     * Set opponentScore
     *
     * @param integer $opponentScore
     *
     * @return Bettings
     */
    public function setOpponentScore($opponentScore)
    {
        $this->opponentScore = $opponentScore;

        return $this;
    }

    /**
     * Get opponentScore
     *
     * @return integer
     */
    public function getOpponentScore()
    {
        return $this->opponentScore;
    }

    /**
     * Set createdAt
     *
     * @param integer $createdAt
     *
     * @return Bettings
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return integer
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param integer $updatedAt
     *
     * @return Bettings
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return integer
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}
