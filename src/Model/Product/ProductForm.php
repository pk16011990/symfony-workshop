<?php
declare(strict_types=1);

namespace App\Model\Product;

use App\Model\Flag\FlagFacade;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ProductForm extends AbstractType
{
    /**
     * @var \App\Model\Flag\FlagFacade
     */
    private $flagFacade;

    public function __construct(FlagFacade $flagFacade)
    {
        $this->flagFacade = $flagFacade;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $flags = $this->flagFacade->getAll();

        $builder
            ->add('name', TextType::class)
            ->add('price', MoneyType::class, [
                'currency' => 'CZK',
            ])
            ->add('hidden', CheckboxType::class, [
                'required' => false,
            ])
            ->add('flags', ChoiceType::class, [
                'required' => false,
                'choices' => $flags,
                'choice_label' => 'name',
                'choice_value' => 'id',
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('submit', SubmitType::class);
    }

}