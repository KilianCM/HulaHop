<?php


namespace App\Forms;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;

class ContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("email", EmailType::class, [
                'label' => 'Ton adresse mail'
            ])
            ->add("subject", null, [
                'label' => 'Le sujet du message'
            ])
            ->add("message", TextareaType::class, [
                'label' => 'Message',
                'attr' => ['rows' => '10']
            ]);
    }
}