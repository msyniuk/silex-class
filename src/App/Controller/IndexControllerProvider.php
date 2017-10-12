<?php

namespace App\Controller;

use Silex\Api\ControllerProviderInterface;
use Silex\Application;
use Silex\ControllerCollection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Form\TestForm;
use App\Form\TestRelationForm;
use Symfony\Component\Form\Form;
use App\Entities\Test;
use App\Entities\TestRelation;
use Doctrine\ORM\EntityManager;

class IndexControllerProvider implements ControllerProviderInterface
{
    private $app;

    /**
     * @return mixed
     */
    public function formAction(Request $request)
    {
        $form = new TestForm($this->app);

        $builded_form = $form->buildForm();
        $builded_form->handleRequest($request);
        $is_submitted = $builded_form->isSubmitted();
        $is_valid = $builded_form->isValid();
        if ($is_valid) {
            /* @var $em EntityManager*/
            $em = $this->app['orm.em'];
            $record = new Test();
            $arr_form = $builded_form->getData();

            $record->setName($arr_form['name']);
            $record->setEmail($arr_form['email']);
            $record->setLoginCount($arr_form['loginCount']);
            $em->persist($record);
            $em->flush();
        }



        $twig_params = [
            'title' => 'Наша тестовая форма',
            'form' => $builded_form->createView(),
            'message' => 'Здесь будет форма'

        ];
        $response = $this->app['twig']->render('form.html.twig', $twig_params);
        return Response::create($response, 200);
    }

    public function form2Action(Request $request)
    {
        $form = new TestRelationForm($this->app);

        $builded_form = $form->buildForm();
        $builded_form->handleRequest($request);
        $is_submitted = $builded_form->isSubmitted();
        $is_valid = $builded_form->isValid();
        if ($is_valid) {
            /* @var $em EntityManager*/
            $em = $this->app['orm.em'];
            $record = new TestRelation();
            $arr_form = $builded_form->getData();

            $record->setName($arr_form['name']);
            $record->setEmail($arr_form['email']);
            $record->setLoginCount($arr_form['loginCount']);
            $em->persist($record);
            $em->flush();
        }



        $twig_params = [
            'title' => 'Наша тестовая форма',
            'form' => $builded_form->createView(),
            'message' => 'Здесь будет форма'

        ];
        $response = $this->app['twig']->render('form.html.twig', $twig_params);
        return Response::create($response, 200);
    }

    public function indexAction(Request $request)
    {
        $name = $request->get('name');
        $id = $request->get('id');
        return Response::create('Hello, world!' . $name . $id, 200);
    }

    private function routing(Request $request)
    {
        $action = $request->get('id') . 'Action';
        return $this->$action($request);
    }

    public function __call($name, $arguments)
    {
        //$name = $request->get('get');
        //$id = $request->get('id');
        $name = str_replace('Action', '', $name);
        return Response::create('Page not found ' . $name, 404);
    }

    public function connect(Application $app)
    {
        $this->app = $app;
        /* @var $controllers ControllerCollection */
        $controllers = $app['controllers_factory'];
        $controllers->match('{id}{trailing_slash}', function (Application $app) {
            return $this->routing($app['request']);
        })
            ->value('id', 'index')
            ->value('trailing_slash', '')
            ->assert('trailing_slash', '/');

        $controllers->match('form/add', function (Application $app) {
            return Response::create('Add', 200);
        });

        return $controllers;
    }


}
