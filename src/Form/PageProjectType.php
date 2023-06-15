<?php

namespace App\Form;

use App\Entity\PageProject;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class PageProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titleHeader', TextType::class)
            ->add('titleBase', TextType::class)
            ->add('desBox1', TextAreaType::class)
            ->add('desBox2', TextAreaType::class)
            ->add('desBox3', TextAreaType::class)
            ->add('imgBox1', FileType::class, [
                'label'=> 'Image du box 1',
                'required' => false, // Si l'upload de l'image est facultatif, sinon, retirez cette ligne
                'attr' => [ //'btn btn-success '
                    'class' => 'btn btn-success',
                    'aria-label'=> 'Choisissez une image',
                ],
            ])
            ->add('imgBox2', FileType::class, [
                'label'=> 'Image du box 2',
                'required' => false, // Si l'upload de l'image est facultatif, sinon, retirez cette ligne
                'attr' => [ //'btn btn-success '
                    'class' => 'btn btn-success',
                    'aria-label'=> 'Choisissez une image',
                ],
            ])
            ->add('imgBox3', FileType::class, [
                'label'=> 'Image du box 3',
                'required' => false, // Si l'upload de l'image est facultatif, sinon, retirez cette ligne
                'attr' => [ //'btn btn-success '
                    'class' => 'btn btn-success',
                    'aria-label'=> 'Choisissez une image',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PageProject::class,
        ]);
    }
}
