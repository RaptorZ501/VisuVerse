<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // Récupérer l'utilisateur depuis les options
        $user = $options['data'];

        $roles = $user->getRoles();
        $defaultRole = '';

        if (in_array('ROLE_ADMIN', $roles)) {
            $defaultRole = 'ROLE_ADMIN';
        } elseif (in_array('ROLE_MEMBRE', $roles)) {
            $defaultRole = 'ROLE_MEMBRE';
        }

        $builder
            ->add('pseudo', TextType::class)
            //->add('password', PasswordType::class)
            ->add('mail', TextType::class)
            ->add('code_postal', IntegerType::class)
            ->add('lastName', TextType::class)
            ->add('firstName', TextType::class)
            /*->add('roles', ChoiceType::class, [
                'choices' => [
                    'Membre' => 'ROLE_MEMBER',
                    'Administrateur' => 'ROLE_ADMIN',
                ],
                'data' => $defaultRole, // Valeur par défaut basée sur les rôles de l'utilisateur
                'multiple' => false,
                'expanded' => false,       
            ])*/;        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
