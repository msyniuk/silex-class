<?php

namespace App\Form;

use Silex\Application;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormFactory;

class OperationForm
{
    private $app;

    /* @return OperationForm */
    public function __construct(Application $app)
    {
        $this->app = $app;
        return $this;
    }

    public function buildForm()
    {
        /* @var $form_factory FormFactory */
        $form_factory = $this->app['form.factory'];
        $form = $form_factory->createBuilder()
            ->add('op_content', null, [
                'label' => 'Операция',
            ])
            ->add('op_date',null, [
                'label' => 'Дата операции',
            ])
            ->add('op_sum', null, [
                'label' => 'Сумма операции',
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Save',
            ])
            ->getForm();
        return $form;
    }
}

