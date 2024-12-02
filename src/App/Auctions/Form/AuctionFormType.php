<?php

declare(strict_types=1);

namespace App\App\Auctions\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

final class AuctionFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('description', TextareaType::class, [
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('startPrice', MoneyType::class, [
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('endDate', DateTimeType::class, [
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('submit', SubmitType::class)
        ;
    }
}
