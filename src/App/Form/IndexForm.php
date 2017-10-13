<?php

namespace App\Form;

use Silex\Application;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormFactory;

class IndexForm
{
    private $app;

    /* @return TestForm */
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
            ->add('all', SubmitType::class, [
                'label' => 'Все операции'])
            ->add('itog', SubmitType::class, [
                'label' => 'Итого'])
            ->add('add', SubmitType::class, [
                'label' => 'Добавить операцию'])
            ->add('edit', SubmitType::class, [
                'label' => 'Редактировать операцию'])
            ->add('del', SubmitType::class, [
                'label' => 'Удалить операцию'])
            ->add('kurs', SubmitType::class, [
                'label' => 'Курсы валют (Приватбанк)',
            ])
            ->getForm();
        return $form;
    }
}

