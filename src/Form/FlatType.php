<?php

namespace App\Form;

use App\Entity\BathroomType;
use App\Entity\BuildingType;
use App\Entity\City;
use App\Entity\Equipment;
use App\Entity\Flat;
use App\Entity\FlatPreference;
use App\Entity\FurnitureType;
use App\Entity\HeatingType;
use App\Entity\KitchenType;
use App\Entity\WindowsType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;

class FlatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',TextType::class,[
                'label' => 'Tytuł ogłoszenia'
            ])
            ->add('description', TextareaType::class,[
                'label' => 'Opis dodatkowy'
            ])
            // TODO
            //->add('latitude', HiddenType::class)
            //->add('longitude', HiddenType::class)
            ->add('latitude')
            ->add('longitude')
            ->add('area', NumberType::class, [
                'label' => 'Metraż',
                'scale' => 2,
                'required' => false
            ])
            ->add('floor', IntegerType::class,[
                'label' => 'Piętro',
                'required' => false
            ])
            ->add('constructionYear', IntegerType::class,[
                'label' => 'Rok budowy budynku',
                'required' => false
            ])
            ->add('floors', IntegerType::class,[
                'label' => 'Ilość pięter w budynku',
                'required' => false
            ])
            ->add('freeFrom', DateType::class, [
                'label' => 'Wolne od',
                'required' => false,
                'widget' => 'single_text'
            ])
            ->add('internet', CheckboxType::class,[
                'label' => 'Internet',
                'required' => false
            ])
            ->add('internetBandwidth', IntegerType::class, [
                'label' => 'Przepustowość internetu (mbit/s)',
                'required' => false
            ])
            ->add('firstName', TextType::class,[
                'label' => 'Imię do kontaktu',
                'required' => false
            ])
            ->add('email')
            ->add('phone1', TextType::class, [
                'label' => 'Pierwszy telefon kontaktowy'
            ])
            ->add('phone2', TextType::class, [
                'label' => 'Drugi telefon kontaktowy',
                'required' => false
            ])
            ->add('flatType', EntityType::class, [
                'class' => \App\Entity\FlatType::class,
                'label' => 'Typ ogłoszenia'
            ])
            ->add('buildingType', EntityType::class, [
                'class' => BuildingType::class,
                'label' => 'Typ budynku',
                'required' => false
            ])
            ->add('furnishings', EntityType::class, [
                'class' => FurnitureType::class,
                'label' => 'Umeblowanie',
                'required' => false
            ])
            ->add('heatingType', EntityType::class, [
                'class' => HeatingType::class,
                'label' => 'Ogrzewanie',
                'required' => false
            ])
            ->add('kitchenType', EntityType::class, [
                'class' => KitchenType::class,
                'label' => 'Kuchnia',
                'required' => false
            ])
            ->add('bathroomType', EntityType::class, [
                'class' => BathroomType::class,
                'label' => 'Łazienka',
                'required' => false
            ])
            ->add('windowsType', EntityType::class, [
                'class' => WindowsType::class,
                'label' => 'Okna',
                'required' => false
            ])
            ->add('equipment', EntityType::class, [
                'class' => Equipment::class,
                'label' => 'Wposażenie',
                'required' => false,
                'multiple' => true,
                'expanded' => true
            ])
            ->add('preferences', EntityType::class, [
                'class' => FlatPreference::class,
                'label' => 'Preferuję',
                'required' => false,
                'multiple' => true,
                'expanded' => true
            ])
            ->add('rooms', CollectionType::class, [
                'entry_type' => RoomType::class,
                'allow_add' => true,
                'prototype' => true
            ])
            ->add('city', Select2EntityType::class,[
                'remote_route' => 'api_city_search',
                'class' => City::class,
                'required' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Flat::class,
        ]);
    }
}
