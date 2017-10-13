<?php

namespace App\Controller;

use Silex\Api\ControllerProviderInterface;
use Silex\Application;
use Silex\ControllerCollection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Form\TestForm;
use App\Form\TestRelationForm;
use App\Form\OperationForm;
use App\Form\IndexForm;
use Symfony\Component\Form\Form;
use App\Entities\Test;
use App\Entities\TestRelation;
use App\Entities\Operations;
use Doctrine\ORM\EntityManager;
use App\Modules\Functions;

class IndexControllerProvider implements ControllerProviderInterface
{
    private $app;
    public $arr_form;
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

    /**
     * @param Request $request
     * @return static
     */
    public function indexAction(Request $request)
    {
        if (isset($_POST['form']['all'])) {
            Functions::allOperations();
        } elseif (isset($_POST['form']['itog'])) {
            Functions::itog();
        } elseif (isset($_POST['form']['add'])) {
            //return Functions::addOperation($request, $this->app);
            $form_op = new OperationForm($this->app);

            $builded_form_op = $form_op->buildForm();
            $builded_form_op->handleRequest($request);
            $this->arr_form = $builded_form_op->getData();
            $twig_params = [
                'title' => 'Добавление операции',
                'form' => $builded_form_op->createView(),
                'message' => 'Форма добавления операции'

            ];
            $response = $this->app['twig']->render('form.html.twig', $twig_params);
            return Response::create($response, 200);
        } elseif (isset($_POST['form']['edit'])) {
            Functions::editOperation();
        } elseif (isset($_POST['form']['del'])) {
            Functions::deleteOperation();
        } elseif (isset($_POST['form']['kurs'])) {
            Functions::kursPrivat();
        } elseif (isset($_POST['form']['submit'])) {
                 /* @var $em EntityManager*/
                $em = $this->app['orm.em'];
                $record = new Operations();

                $record->setOpContent($this->arr_form['op_content']);
                $record->setOpDate($this->arr_form['op_date']);
                $record->setOpSum($this->arr_form['op_sum']);
                $record->setOpSumusd($this->arr_form['op_sum']/Functions::getKurs());
                $em->persist($record);
                $em->flush();

        }

        $form = new IndexForm($this->app);

        $builded_form = $form->buildForm();
        $builded_form->handleRequest($request);
        $twig_params = [
            'title' => 'Главная страница',
            'form' => $builded_form->createView(),
            'message' => 'Здесь будет меню'

        ];
        $response = $this->app['twig']->render('index.html.twig', $twig_params);
        return Response::create($response, 200);
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
