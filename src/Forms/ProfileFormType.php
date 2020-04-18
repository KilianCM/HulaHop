<?php


namespace App\Forms;


use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfileFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("email", EmailType::class, [
                'label' => 'Ton adresse mail'
            ])

            ->add("name", null,[
                'label' => 'Ton pseudo'
            ])
            ->add("address", null, [
                'label' => 'Ton adresse'
            ])
            ->add("imageUrl", null, [
                'label' => 'Ton image'
            ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }


}