<?php

namespace App\Form;

use App\DTO\OtvRequest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;


class OtvType extends AbstractType
{
    /**
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('civility', ChoiceType::class, [
                'label' => 'Civilité',
                'required' => false,
                'attr' => ['class' => 'form-control'], 
                'choices' => [
                    'M.' => 'M.',
                    'Mme' => 'Mme',
                    'Autre' => 'Autre',
                ],
                'placeholder' => 'Choissisez une civilité',

            ])
            ->add('otherCivility', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'class' => 'form-control mt-2', 
                    'id' => 'otherCivility', 
                    'style' => 'display: none;',
                    'placeholder' => 'Ajouter une civilité',
                ]
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Nom',
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez saisir votre nom.'])
                ],
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
                'required' => true,
                'attr' => [
                    'class' => 'form-control'
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez saisir votre prénom.'])
                ]
            ])

            ->add('district', ChoiceType::class, [
                'label' => 'Quartier',
                'choices' => [
                    'Belles Terres' => 'Belles Terres',
                    'Bourg-Centre Ville' => 'Bourg-Centre Ville',
                    'Briqueterie' => 'Briqueterie',
                    'Buisson/May-Four/Pellevoisin' => 'Buisson/May-Four/Pellevoisin',
                    'Croisé-Laroche/Rouges-Barres' => 'Croisé-Laroche/Rouges-Barres',
                    'Mairie / Hippodrome' => 'Mairie / Hippodrome',
                    'Plouich/Clemenceau/Calmette' => 'Plouich/Clemenceau/Calmette',
                    'Pont/Monplaisir' => 'Pont/Monplaisir',
                ],
                'required' => false,
                'placeholder' => 'Veuillez sélectionner un quartier',
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez choisir une option.'])
                ]
            ])
            ->add('comments', TextareaType::class, [
                'label' => false,
                'required' => false,
                'attr' => ['class' => 'form-control'],
            ])
            ->add('street', TextType::class, [
                'label' => 'Rue',
                'required' => false,
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez saisir votre rue.'])
                ]
            ])
            ->add('streetNumber', TextType::class, [
                'label' => 'Numéro de rue',
                'required' => false,
                'attr' => ['class' => 'form-control']
            ])
            ->add('additionalStreetNumber', TextType::class, [
                'label' => 'Complément du numéro de rue',
                'required' => false,
                'attr' => ['class' => 'form-control']
            ])
            ->add('additionalAddressInfo', TextType::class, [
                'label' => 'Informations complémentaires sur l\'adresse',
                'required' => false,
                'attr' => ['class' => 'form-control']
            ])
            ->add('mobilePhone', TelType::class, [
                'label' => 'Téléphone mobile',
                'required' => false,               
                 'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez saisir votre numéro de téléphone.']),
                    new Regex([
                        //Le pattern prends en compte différents format de numéro de téléphone français: 0123456789, 01 23 45 67, 89 01.23.45.67.89, 0123 45.67.89, 0033 123-456-789, +33-1.23.45.67.89, +33 - 123 456 789, +33(0) 123 456 789, +33 (0)123 45 67 89, +33 (0)1 2345-6789, +33(0) - 123456789
                        'pattern' => '/^(?:(?:\+|00)33[\s.-]{0,3}(?:\(0\)[\s.-]{0,3})?|0)[1-9](?:(?:[\s.-]?\d{2}){4}|\d{2}(?:[\s.-]?\d{3}){2})$/',
                        'message' => 'Veuillez entrer un numéro de téléphone mobile valide.'
                    ])
                ]
            ])
            ->add('landlinePhone', TelType::class, [
                'label' => 'Téléphone fixe',
                'required' => false,
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new Regex([
                        'pattern' => '/^(?:(?:\+|00)33[\s.-]{0,3}(?:\(0\)[\s.-]{0,3})?|0)[1-9](?:(?:[\s.-]?\d{2}){4}|\d{2}(?:[\s.-]?\d{3}){2})$/',
                        'message' => 'Veuillez entrer un numéro de téléphone mobile valide.'
                    ])
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Courriel',
                'required' => false,               
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez saisir votre courriel.']),
                    new Email(['message' => 'Veuillez entrer une adresse email valide.']),
                ]
            ])
            ->add('houseType', TextType::class, [
                'label' => 'Type de Logement',
                'required' => false,
                'attr' => ['class' => 'form-control'],
            ])
            ->add('hasAlarm', ChoiceType::class, [
                'label' => 'Le logement possède-t-il une alarme ?',
                'choices' => [
                    'Oui' => true,
                    'Non' => false
                ],
                'expanded' => true,
                'multiple' => false,
                'required' => true,
                'attr' => ['class' => 'form-check form-check-inline'],
              /*   'constraints' => [
                    new NotNull(['message' => 'Veuillez sélectionner une option.'])
                ], */
            ])
            ->add('hasAlarmExt', ChoiceType::class, [
                'label' => 'Le logement possède-t-il une alarme extérieure ?',
                'choices' => [
                    'Oui' => true,
                    'Non' => false
                ],
                'expanded' => true,
                'multiple' => false,
                'required' => true,
                'attr' => ['class' => 'form-check form-check-inline'],
                /* 'constraints' => [
                    new NotNull(['message' => 'Veuillez sélectionner une option.'])
                ], */
            ])
            ->add('hasCamera', ChoiceType::class, [
                'label' => 'Le logement possède-t-il des caméras ?',
                'choices' => [
                    'Oui' => true,
                    'Non' => false
                ],
                'expanded' => true,
                'multiple' => false,
                'required' => true,
                'attr' => ['class' => 'form-check form-check-inline'],
              /*   'constraints' => [
                    new NotNull(['message' => 'Veuillez sélectionner une option.'])
                ], */
            ])
            ->add('hasAnimal', ChoiceType::class, [
                'label' => 'Y a-t-il des animaux dans le logement ?',
                'choices' => [
                    'Oui' => true,
                    'Non' => false
                ],
                'expanded' => true,
                'multiple' => false,
                'required' => true,
                'attr' => ['class' => 'form-check form-check-inline'],
               /*  'constraints' => [
                    new NotNull(['message' => 'Veuillez sélectionner une option.'])
                ], */
            ])
            ->add('blindsSchedule', TimeType::class, [
                'label' => 'Horaire de programmation automatique des volets',
                'required' => false,
                'input' => 'string',
                'attr' => ['class' => 'form-control']
            ])
            ->add('lightsSchedule', TimeType::class, [
                'label' => 'Horaire de programmation automatique des éclairages',
                'required' => false,
                'input' => 'string',
                'attr' => ['class' => 'form-control']
            ])
            ->add('car', TextType::class, [
                'label' => 'Immatriculation ou marque et couleur du véhicule devant le garage',
                'required' => false,
                'attr' => ['class' => 'form-control']
            ])
            ->add('additionalInfo', TextareaType::class, [
                'label' => 'Informations supplémentaires',
                'required' => false,
                'attr' => ['class' => 'form-control']
            ])
            ->add('authorizedPersons', TextType::class, [
                'label' => 'Nom et prénom des personnes susceptibles de passer dans l’habitation',
                'required' => false,
                'attr' => ['class' => 'form-control']
            ])
            ->add('startDate', DateType::class, [
                'label' => 'Date de Début',
                'required' => false,
                'attr' => ['class' => 'form-control', 'id' => 'start_Date'],
            ])

            ->add('endDate', DateType::class, [
                'label' => 'Date de Fin',
                'required' => false,
                'attr' => ['class' => 'form-control', 'id' => 'end_Date'],
            ])

            ->add('emergencyCivility1', TextType::class, [
                'label' => 'Civilité',
                'required' => false,
                'attr' => ['class' => 'form-control']
            ])
            ->add('emergencyLastname1', TextType::class, [
                'label' => 'Nom',
                'required' => false,
                'attr' => ['class' => 'form-control']
            ])
            ->add('emergencyFirstname1', TextType::class, [
                'label' => 'Prénom',
                'required' => false,
                'attr' => ['class' => 'form-control']
            ])
            ->add('emergencyMobilePhone1', TelType::class, [
                'label' => 'Téléphone mobile',
                'required' => false,
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new Regex([
                        'pattern' => '/^(0|\+33)[1-9]( *[0-9]{2}){4}$/',
                        'message' => 'Veuillez entrer un numéro de téléphone mobile valide.'
                    ])
                ]
            ])
            ->add('emergencyLandlinePhone1', TelType::class, [
                'label' => 'Téléphone fixe',
                'required' => false,
                'attr' => ['class' => 'form-control']
            ])
            ->add('emergencyEmail1', EmailType::class, [
                'label' => 'Courriel',
                'required' => false,
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new Regex([
                        'pattern' => '/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/',
                        'message' => 'Veuillez entrer une adresse email valide.'
                    ])
                ]
            ])

            ->add('emergencyCivility2', TextType::class, [
                'label' => 'Civilité',
                'required' => false,
                'attr' => ['class' => 'form-control']
            ])
            ->add('emergencyLastname2', TextType::class, [
                'label' => 'Nom',
                'required' => false,
                'attr' => ['class' => 'form-control']
            ])
            ->add('emergencyFirstname2', TextType::class, [
                'label' => 'Prénom',
                'required' => false,
                'attr' => ['class' => 'form-control']
            ])
            ->add('emergencyMobilePhone2', TelType::class, [
                'label' => 'Téléphone mobile',
                'required' => false,
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new Regex([
                        'pattern' => '/^(0|\+33)[1-9]( *[0-9]{2}){4}$/',
                        'message' => 'Veuillez entrer un numéro de téléphone mobile valide.'
                    ])
                ]
            ])
            ->add('emergencyLandlinePhone2', TelType::class, [
                'label' => 'Téléphone fixe',
                'required' => false,
                'attr' => ['class' => 'form-control']
            ])
            ->add('emergencyEmail2', EmailType::class, [
                'label' => 'Courriel',
                'required' => false,
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new Regex([
                        'pattern' => '/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/',
                        'message' => 'Veuillez entrer une adresse email valide.'
                    ])
                ]
            ])

            ->add('emergencyCivility3', TextType::class, [
                'label' => 'Civilité',
                'required' => false,
                'attr' => ['class' => 'form-control']
            ])
            ->add('emergencyLastname3', TextType::class, [
                'label' => 'Nom',
                'required' => false,
                'attr' => ['class' => 'form-control']
            ])
            ->add('emergencyFirstname3', TextType::class, [
                'label' => 'Prénom',
                'required' => false,
                'attr' => ['class' => 'form-control']
            ])
            ->add('emergencyMobilePhone3', TelType::class, [
                'label' => 'Téléphone mobile',
                'required' => false,
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new Regex([
                        'pattern' => '/^(0|\+33)[1-9]( *[0-9]{2}){4}$/',
                        'message' => 'Veuillez entrer un numéro de téléphone mobile valide.'
                    ])
                ]
            ])
            ->add('emergencyLandlinePhone3', TelType::class, [
                'label' => 'Téléphone fixe',
                'required' => false,
                'attr' => ['class' => 'form-control']
            ])
            ->add('emergencyEmail3', EmailType::class, [
                'label' => 'Courriel',
                'required' => false,
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new Regex([
                        'pattern' => '/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/',
                        'message' => 'Veuillez entrer une adresse email valide.'
                    ])
                ]
            ])
            ->add('latitude', HiddenType::class)
            ->add('longitude', HiddenType::class)
            ;
    }

    /**
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
            'data_class' => OtvRequest::class,
        ]);
    }

}
