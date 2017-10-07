<?php

namespace App\Controller;

use Silex\Api\ControllerProviderInterface;
use Silex\Application;
use Silex\ControllerCollection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Form\TestForm;

class IndexControllerProvider implements ControllerProviderInterface
{
    private $app;

    /**
     * @return mixed
     */
    public function formAction(Request $request)
    {
        $form = new TestForm($this->app);
        $twig_params = [
            'title' => 'Наша тестовая форма',
            'form' => $form->buildForm()->createView(),
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
        return $controllers;
    }


}
