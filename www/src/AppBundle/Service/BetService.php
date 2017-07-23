<?php

namespace AppBundle\Service;

use AppBundle\Entity\Bettings;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormError;

/**
 * Class BetService
 *
 * @package AppBundle\Service
 */
class BetService
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var Form
     */
    private $form;

    /**
     * @var array
     */
    private $params = [];

    /**
     * DataService constructor.
     *
     * @param RequestStack $requestStack
     * @param EntityManager $entityManager
     */
    public function __construct(RequestStack $requestStack, EntityManager $entityManager)
    {
        $this->request = $requestStack->getCurrentRequest();
        $this->entityManager = $entityManager;
    }

    /**
     * Set form
     *
     * @param Form $form
     *
     * @return BetService
     */
    public function setForm($form)
    {
        $this->form = $form;

        return $this;
    }

    /**
     * Set params
     *
     * @param array $params
     *
     * @return BetService
     */
    public function setParams($params)
    {
        $this->params = $params;

        return $this;
    }

    /**
     * Validate bet form
     *
     * @return bool
     *
     * @throws \Exception
     */
    public function validateBetForm()
    {
        if (!$this->form) {
            throw new \Exception('The form is not set');
        }

        if (empty($this->params['player_id'])) {
            $this->form->addError(new FormError('player_id is not set'));
        }

        if (empty($this->params['game_id'])) {
            $this->form->addError(new FormError('game_id is not set'));
        }

        if (empty($this->params['amount'])) {
            $this->form->addError(new FormError('amount is not set'));
        }

        return !(boolean)count($this->form->getErrors(true));
    }

    /**
     * Validate score form
     *
     * @return bool
     *
     * @throws \Exception
     */
    public function validateScoreForm()
    {
        if (!$this->form) {
            throw new \Exception('The form is not set');
        }

        if (empty($this->params['player_id'])) {
            $this->form->addError(new FormError('player_id is not set'));
        }

        if (empty($this->params['bet_id'])) {
            $this->form->addError(new FormError('bet_id is not set'));
        }

        if (empty($this->params['score'])) {
            $this->form->addError(new FormError('score is not set'));
        }

        return !(boolean)count($this->form->getErrors(true));
    }

    /**
     * Find bet and submit posted data
     *
     * @return Bettings|null
     */
    public function bet()
    {
        if (!$this->validateBetForm()) {
            return null;
        }

        /** @var Bettings $bet */
        $bet = $this->entityManager
            ->getRepository('AppBundle:Bettings')
            ->findBetForBetForm($this->params);

        $this->form->setData($bet);

        if (!$bet->getId()) {
            $this->form->submit([
                'originGuid' => $this->params['player_id'],
                'gameId'     => $this->params['game_id'],
                'amount'     => $this->params['amount'],
                'start'      => 0,
                'status'     => Bettings::STATUS_OFFERED,
            ]);
        } else {
            switch ($this->params['amount'] <=> $bet->getAmount()) {
                case -1:
                    $this->form->addError(new FormError('Your bet is to small'));
                    break;
                case 0:
                    if ($this->params['player_id'] == $bet->getOriginGuid() && empty($bet->getOpponentGuid())) {
                        $this->form->addError(new FormError('Your bet is already exist'));
                    } else {
                        $this->form->submit([
                            'originGuid'   => $bet->getOriginGuid(),
                            'opponentGuid' => $this->params['player_id'],
                            'gameId'       => $bet->getGameId(),
                            'amount'       => $bet->getAmount(),
                            'start'        => (new \DateTime('now'))->getTimestamp(),
                            'status'       => Bettings::STATUS_ACCEPTED,
                        ]);
                    }
                    break;
                case 1:
                    if ($this->params['player_id'] == $bet->getOriginGuid()) {
                        $this->form->submit([
                            'originGuid' => $bet->getOriginGuid(),
                            'gameId'     => $bet->getGameId(),
                            'amount'     => $this->params['amount'],
                            'start'      => $bet->getStart(),
                            'status'     => $bet->getStatus(),
                        ]);
                    } else {
                        $this->form->submit([
                            'originGuid'   => $bet->getOriginGuid(),
                            'opponentGuid' => $this->params['player_id'],
                            'gameId'       => $bet->getGameId(),
                            'amount'       => $this->params['amount'],
                            'start'        => $bet->getStart(),
                            'status'       => $bet->getStatus(),
                        ]);
                    }
                    break;
            }
        }

        return $bet;
    }

    /**
     * Find bet and update score for player
     *
     * @return Bettings|null
     */
    public function score()
    {
        if (!$this->validateScoreForm()) {
            return null;
        }

        /** @var Bettings $bet */
        $bet = $this->entityManager
            ->getRepository('AppBundle:Bettings')
            ->findBetForScoreForm($this->params);

        if (!$bet) {
            $this->form->addError(new FormError('bet not fond'));
            return null;
        }

        $this->form->setData($bet);

        if ($this->params['player_id'] == $bet->getOriginGuid()) {
            $this->form->submit([
                'originGuid'    => $bet->getOriginGuid(),
                'opponentGuid'  => $bet->getOpponentGuid(),
                'originScore'   => $this->params['score'],
                'opponentScore' => $bet->getOpponentScore(),
            ]);
        } else {
            $this->form->submit([
                'originGuid'    => $bet->getOriginGuid(),
                'opponentGuid'  => $bet->getOpponentGuid(),
                'originScore'   => $bet->getOriginScore(),
                'opponentScore' => $this->params['score'],
            ]);
        }

        return $bet;
    }
}