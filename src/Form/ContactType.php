<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
class ContactType extends AbstractType

{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('email')
          
            ->add('pays', ChoiceType::class, [
                'label' => 'Pays',
                'choices' => [
                    'Maroc' => 'MA',
                    'France' => 'FR',
                    'États-Unis' => 'US',
                    'Canada' => 'CA',
                ],
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Message'
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
