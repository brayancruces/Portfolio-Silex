<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints as Assert;


// -- BACKEND -----------------------------------------------------------------
//$app->mount('/admin', include 'backend.php');


// -- PORTADA -----------------------------------------------------------------
$app->get('/', function () use ($app) {
    return $app['twig']->render('home.twig', array('section' => 'home'));
})->bind('home');


// -- SOBRE MI -----------------------------------------------------------------
$app->get('/sobremi', function () use ($app) {
    return $app['twig']->render('aboutme.twig', array('section' => 'aboutme'));
})->bind('aboutme');


// -- PORTFOLIO -----------------------------------------------------------------
$app->get('/portfolio', function () use ($app) {
    return $app['twig']->render('portfolio.twig', array('section' => 'portfolio'));
})->bind('portfolio');


// -- SERVICIOS -----------------------------------------------------------------
$app->get('/servicios', function () use ($app) {
    return $app['twig']->render('services.twig', array('section' => 'services'));
})->bind('services');


// -- CONTACTO -----------------------------------------------------------------
$app->match('/contacto', function (Request $request) use ($app) {
    //Crea formulario
    $form = $app['form.factory']->createBuilder('form')
        ->add('subject', 'text',
              array('label'       => 'Asunto',
                    'constraints' => array(new Assert\MinLength(5))))
        ->add('name', 'text',
              array('label'       => 'Nombre',
                    'constraints' => array(new Assert\MinLength(3))))
        ->add('email', 'text',
              array('label'       => 'Email',
                    'constraints' => array(new Assert\Email(array(
                                                            'message' => 'El email "{{ value }}" no es válido.',
                                                            'checkMX' => true,
        )))))
        ->add('phone', 'text',
              array('label'       => 'Teléfono',
                    'required'    => false,
                    'constraints' => array(new Assert\Regex(array(
                                                            'message' => 'El número no es válido',
                                                            'pattern' => '/\d{9}/',
        )))))
        ->add('message', 'textarea',
              array('label'       => 'Mensaje',
                    'constraints' => array(new Assert\MinLength(10))))
        ->getForm();

    //Llegan los datos
    if ($request->isMethod('POST')) {
        $form->bind($request);

        if ($form->isValid()) {

            $data   = $form->getData();
            $email  = '<html><head><title>Contacto '.$data['name'].'</title></head><body>';
            $email .= '<h1>'.$data['subject'].'</h1>';
            $email .= '<h2>Nombre: '.$data['name'].'</h2>';
            $email .= '<h2>Teléfono: '.$data['phone'].'</h2>';
            $email .= '<h2>Email: '.$data['email'].'</h2>';
            $email .= '<br/><p>'.$data['message'].'</p>';
            $email .= '</body></html>';

            $message = \Swift_Message::newInstance()
            ->setSubject($data['subject'])
            ->setFrom(array($data['email']))
            ->setTo(array('info@imaginand.com'))
            ->setBody($email,'text/html');
     
            $app['mailer']->send($message);

            return $app['twig']->render('send.twig', array('section' => 'send'));
        }
    }

    return $app['twig']->render('contact.twig', array('section' => 'contact',
                                                      'form'    => $form->createView()
                                                ));
})->bind('contact');



// -- PÁGINAS DE ERROR --------------------------------------------------------
/*$app->error(function (\Exception $e, $code) use ($app) {
    switch ($code) {
        case 404:
            $message = 'Página no encontrada.';
            break;
        default:
            $message = 'Lo sentimos, se ha producido un error. Prueba en otro momento o contacta con nosotros.';
    }
    return $message;
});*/

/*$app->error(function (\Exception $e, $code) use ($app) {
    if ($app['debug']) {
        return;
    }
    // logic to handle the error and return a Response
});*/