<?php

namespace App\Form;

use App\Entity\Equipment;
use App\Entity\Lessee;
use App\Entity\Property;
use App\Repository\LesseeRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class PropertyType
 * @package App\Form
 */
class PropertyType extends AbstractType
{
    /**
     * @var TokenStorageInterface
     */
    private $token;

    /**
     * PropertyType constructor.
     * @param TokenStorageInterface $token
     */
    public function __construct(TokenStorageInterface $token)
    {
        $this->token = $token;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('propertyCategory', ChoiceType::class, [
                'required' => true,
                'choices' => [
                    'Appartement' => 'Appartement',
                    'Maison' => 'Maison',
                    'Garage' => 'Garage',
                    'Bureau' => 'Bureau',
                    'Château' => 'Château',
                    'Commerce' => 'Commerce',
                ],
                'label' => 'Type de bien'
            ])
            ->add('uniqueName', TextType::class, ['required' => true, 'label' => 'Nom unique'])
            ->add('address', TextType::class, ['required' => true, 'label' => 'Adresse'])
            ->add('city', TextType::class, ['required' => true, 'label' => 'Ville'])
            ->add('zipCode', IntegerType::class, ['required' => true, 'label' => 'Code postal'])
            ->add('country', CountryType::class, ['required' => true, 'label' => 'Pays'])
            ->add('surfaceInSquareMeter', IntegerType::class, [
                'required' => true,
                'label' => 'Surface en m²'
            ])
            ->add('numberOfPiece', IntegerType::class, ['required' => true, 'label' => 'Nombre de pièces'])
            ->add('description', TextType::class, ['required' => false, 'label' => 'Description'])
            ->add('equipment', EntityType::class, [
                'required' => false,
                'label' => 'Equipements',
                'class' => Equipment::class,
                'multiple' => true,
                'expanded' => true,
                'choice_label' => 'name',
                'by_reference' => false,
            ])
            ->add('rentalCategory', ChoiceType::class, [
                'required' => true,
                'choices' => [
                    'Meublé' => 'Meublé',
                    'Non meublé' => 'Non meublé',
                ],
                'label' => 'Type de location'
            ])
            ->add('rentExcludingCharges', NumberType::class, [
                'required' => true,
                'label' => 'Loyer hors charges'
            ])
            ->add('charges', NumberType::class, ['required' => true, 'label' => 'Charges'])
            ->add('purchasePrice', NumberType::class, ['required' => true, 'label' => 'Prix d\'achat'])
            ->add('lessees', EntityType::class, [
                'required' => false,
                'label' => 'Locataires',
                'class' => Lessee::class,
                'multiple' => true,
                'expanded' => true,
                'by_reference' => false,
                'choice_label' => 'fullName',
                'query_builder' => function (LesseeRepository $propertyRepository) {
                    $user = $this->token->getToken()->getUser();
                    return $propertyRepository->findLessesByUser($user);
                },
            ])
            ->add('pdfFile', FileType::class, [
                'label' => 'Fichiers PDF',
                'required' => false,
                'data_class' => null,
                'multiple' => true,
                'attr' => [
                    'accept' => 'application/pdf',
                ],
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Property::class,
        ]);
    }
}
