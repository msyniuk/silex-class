<?php

namespace App\Modules;

use App\Controller\IndexControllerProvider;
use Silex\Application;
use App\Entities\Operations;
use App\Form\OperationForm;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormFactory;
use Silex\Api\ControllerProviderInterface;
use Silex\ControllerCollection;
use Symfony\Component\Form\Form;
use Doctrine\ORM\EntityManager;

define("LINK", 'https://api.privatbank.ua/p24api/pubinfo?json&exchange&coursid=5');

class Functions
{

    public function allOperations()
    {
        echo 'all operations';
    }

    public function itog()
    {
        echo 'itog';
    }

    public function deleteOperation()
    {
        echo 'delete operation';
    }

    public function addOperation(Request $request, $app)
    {

        $form_op = new OperationForm($app);

        $builded_form_op = $form_op->buildForm();
        $builded_form_op->handleRequest($request);
        $is_submitted = $builded_form_op->isSubmitted();
        $is_empty = $builded_form_op->isEmpty();
        if ($is_empty) {
            /* @var $em EntityManager*/
            $em = $app['orm.em'];
            $record = new Operations();
            $arr_form = $builded_form_op->getData();

            $record->setOpContent($arr_form['op_content']);
            $record->setOpDate($arr_form['op_date']);
            $record->setOpSum($arr_form['op_sum']);
            $record->setOpSumusd($arr_form['op_sum']/self::getKurs());
            $em->persist($record);
            $em->flush();
        }

        $twig_params = [
            'title' => 'Добавление операции',
            'form' => $builded_form_op->createView(),
            'message' => 'Форма добавления операции'

        ];
        $response = $app['twig']->render('form.html.twig', $twig_params);
        return Response::create($response, 200);
    }


    public function editOperation()
    {
        echo 'edit operation';
    }

    public function kursPrivat()
    {
        $data = file_get_contents(LINK);
        $courses = json_decode($data,true);
        print ('<table border="1">');
        foreach ($courses as $course){
            print '<td><td>'.$course['ccy'] . '</td><td>' .
                round($course['buy'],2) . '</td><td>' .
                round($course['sale'],2) . '</td></tr>';

        }
        print ('</table>');
        print self::getKurs();
    }

    public function getKurs($ccy = 'USD')
    {
        $data = file_get_contents(LINK);
        if (!$data) return false;
        $courses = json_decode($data,true);
        $course_curr = false;
        foreach ($courses as $course){
            if($course['ccy'] === $ccy){
                $course_curr = $course['buy'];
                break;
            }
        }
        return $course_curr;
    }
}

