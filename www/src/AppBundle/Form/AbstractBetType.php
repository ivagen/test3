<?php

namespace AppBundle\Form;

use AppBundle\Entity\Bettings;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class AbstractBetType
 *
 * @package AppBundle\Form
 */
abstract class AbstractBetType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'      => Bettings::class,
            'csrf_protection' => false,
        ]);
    }
}
