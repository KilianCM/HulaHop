<?php


namespace App\Forms;


use App\Entity\Rating;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RatingFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("note", NumberType::class, [
                "label" => "Note : ",
                "html5" => true,
                "attr" => [
                    "min" => 0,
                    "max" => 5
                ]

            ])

            ->add("comment", null, [
                "label" => "Commentaire : "
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Rating::class
        ]);
    }
}