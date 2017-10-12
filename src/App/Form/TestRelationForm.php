<?php

namespace App\Form;

use App\Entities\TestRelation;
use Silex\Application;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormFactory;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class TestRelationForm
{
    private $app;

    /* @return TestRelationForm */
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
            ->add('name')
            ->add('email')
            ->add('loginCount')
            ->add('submit', SubmitType::class, [
                'label' => 'Save',
            ])
            ->getForm();
        return $form;
    }
}

