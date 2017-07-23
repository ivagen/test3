<?php

namespace AppBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class ScoreType
 *
 * @package AppBundle\Form
 */
class ScoreType extends AbstractBetType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('originGuid')
            ->add('opponentGuid')
            ->add('originScore')
            ->add('opponentScore');
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'score';
    }
}
