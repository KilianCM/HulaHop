<?php


namespace App\Forms;



use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;

class AddressFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("address", null, [
                "label" => "Ton adresse",
            ])

            ->add("city", null, [
                "label" => "Ta ville",
            ])

            ->add("postalCode", null, [
                "label" => "Ton code postal"

            ]);

    }
}