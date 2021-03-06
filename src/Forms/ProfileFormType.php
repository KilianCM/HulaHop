<?php


namespace App\Forms;


use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use function Sodium\add;

class ProfileFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("email", EmailType::class, [
                'label' => 'Email : '
            ])
            ->add("name", null,[
                'label' => 'Pseudo : '
            ])
            ->add("address", null, [
                'label' => 'Adresse : '
            ])
            ->add("postalCode", null, [
                'label' => "Code postal : "
            ])
            ->add("city", null, [
                'label' => 'Ville : '
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }


}