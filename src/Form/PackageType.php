<?php declare(strict_types=1);

/*
 * This file is part of the package bk2k/packagebuilder.
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace App\Form;

use App\Entity\Package;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * PackageType.
 */
class PackageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setAction($options['action'])
            ->add('typo3Version', ChoiceType::class, [
                'label' => 'TYPO3 Version',
                'choices' => [
                    '11.5' => 11005000,
                    '10.4' => 10004000,
                    '9.5' => 9005000,
                    '8.7' => 8007000,
                ],
                'expanded' => true,
            ])
            ->add('basePackage', ChoiceType::class, [
                'label' => 'Base Package',
                'choices' => [
                    'ncn TYPO3 Package + Custom Theme' => 'ncn_custom_package',
                    'ncn Custom Theme only' => 'ncn_custom_theme',
                    'Bootstrap Package' => 'bootstrap_package',
                    'Fluid Styled Content' => 'fluid_styled_content',
                ],
                'expanded' => true,
            ])
            ->add('title', TextType::class, [
                'attr' => [
                    'autocomplete' => 'off',
                    'placeholder' => 'Vendor',
                ],
            ])
            ->add('description', TextareaType::class, [
                'required' => false,
                'attr' => [
                    'autocomplete' => 'off',
                    'placeholder' => 'Optional description for the use of this sitepackage',
                ],
            ])
            ->add('repositoryUrl', TextType::class, [
                'label' => 'Repository URL',
                'required' => false,
                'attr' => [
                    'autocomplete' => 'off',
                    'placeholder' => 'https://github.com/username/my_sitepackage',
                ],
            ])

            ->add('serverUrl', TextType::class, [
                'label' => 'Server',
                'required' => false,
                'attr' => [
                    'autocomplete' => 'off',
                    'placeholder' => 'p999999@p999999.webspaceconfig.de',
                ],
            ])

            ->add('serverPath', TextType::class, [
                'label' => 'Server path',
                'required' => false,
                'attr' => [
                    'autocomplete' => 'off',
                    'placeholder' => '/home/www/p999999/html/typo3-composer',
                ],
            ])

            ->add('author', AuthorType::class)
        
            ->add('websiteTitle', TextType::class, [
                'attr' => [
                    'autocomplete' => 'off',
                    'placeholder' => 'Website Pagetitle',
                ],
            ])

            ->add('domain', TextType::class, [
                'attr' => [
                    'autocomplete' => 'off',
                    'placeholder' => 'domain.tld',
                ],
            ])

            ->add('defaultEmail', TextType::class, [
                'attr' => [
                    'autocomplete' => 'off',
                    'placeholder' => 'info@domain.tld',
                ],
            ])

            ->add('defaultSenderName', TextType::class, [
                'attr' => [
                    'autocomplete' => 'off',
                    'placeholder' => 'Company',
                ],
            ])

            ->add('defaultSenderEmail', TextType::class, [
                'attr' => [
                    'autocomplete' => 'off',
                    'placeholder' => 'noreply@domain.tld',
                ],
            ]);
    }

    public function setDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Package::class,
        ]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'packageForm';
    }
}
