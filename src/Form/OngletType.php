<?php

namespace App\Form;

use App\Entity\Onglet;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Image;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;



class OngletType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $label = $options['label']; // Accédez à l'option 'label'

        $builder
            ->add('imageFile', FileType::class, [
                'label'=> $label,
                'required' => false, // Si l'upload de l'image est facultatif, sinon, retirez cette ligne
                'attr' => [ //'btn btn-success '
                    'class' => 'btn btn-success',
                    'aria-label'=> 'Choisissez une image',
                ],
            ])
            ->add('title', TextType::class, [                
               'constraints' => [
                    new NotBlank([
                        'message' => 's\'il vous plais entrez un titre'
                    ]),
                    new Length([
                        'max' => 50, // Maximum 50 caractères
                        'maxMessage' => 'Ne peut dépasser {{ limit }} caractères.',
                    ]),
               ],
            ])
            ->add('description', TextAreaType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Onglet::class,
        ]);
    }
}
