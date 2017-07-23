<?php

namespace AppBundle\Controller;

use AppBundle\Form\BetType;
use AppBundle\Form\ScoreType;
use JMS\Serializer\SerializationContext;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class BettingsController
 *
 * @package AppBundle\Controller
 */
class BettingsController extends Controller
{
    /**
     * Main page.
     *
     * @Route("/", name="bettings_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $formBet = $this->createForm(BetType::class);
        $formScore = $this->createForm(ScoreType::class);

        $em = $this->getDoctrine()->getManager();
        $bettings = $em
            ->getRepository('AppBundle:Bettings')
            ->findAll();

        return $this->render('bettings/index.html.twig', [
            'bettings'   => $bettings,
            'form_bet'   => $formBet->createView(),
            'form_score' => $formScore->createView(),
        ]);
    }

    /**
     * Lists all betting entities.
     *
     * @Route("/list", name="bettings_list")
     * @Method("GET")
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $bettings = $em
            ->getRepository('AppBundle:Bettings')
            ->findAll();

        return new JsonResponse(
            $this->container
                ->get('jms_serializer')
                ->toArray($bettings, (new SerializationContext())
                    ->setSerializeNull(true)),
            JsonResponse::HTTP_OK
        );
    }

    /**
     * Actions of bets.
     *
     * @Route("/bet", name="bettings_bet")
     * @Method("POST")
     */
    public function betAction(Request $request)
    {
        $post = json_decode($request->getContent(), true);
        $form = $this->createForm(BetType::class);

        $betting = $this->get('app.bet.service')
            ->setForm($form)
            ->setParams($post)
            ->bet();

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($betting);
            $em->flush();

            return new JsonResponse(
                null,
                JsonResponse::HTTP_CREATED
            );
        }

        return new JsonResponse(
            [
                'errors' => $this->container
                    ->get('jms_serializer')
                    ->toArray($form->getErrors(true))['errors'],
            ],
            JsonResponse::HTTP_BAD_REQUEST
        );
    }

    /**
     * Actions of score.
     *
     * @Route("/score", name="bettings_score")
     * @Method("POST")
     */
    public function scoreAction(Request $request)
    {
        $post = json_decode($request->getContent(), true);
        $form = $this->createForm(ScoreType::class);

        $betting = $this->get('app.bet.service')
            ->setForm($form)
            ->setParams($post)
            ->score();

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($betting);
            $em->flush();

            return new JsonResponse(
                null,
                JsonResponse::HTTP_ACCEPTED
            );
        }

        return new JsonResponse(
            [
                'errors' => $this->container
                    ->get('jms_serializer')
                    ->toArray($form->getErrors(true))['errors'],
            ],
            JsonResponse::HTTP_BAD_REQUEST
        );
    }
}
