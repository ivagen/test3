<?php

namespace AppBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class BetType
 *
 * @package AppBundle\Form
 */
class BetType extends AbstractBetType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('originGuid')
            ->add('opponentGuid')
            ->add('gameId')
            ->add('amount')
            ->add('status')
            ->add('start')
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'bet';
    }
}
