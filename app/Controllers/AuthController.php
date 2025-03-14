<?php

namespace App\Controllers;

use App\Models\Usuario;
use App\Controllers\BaseController;
use \Respect\Validation\Validator as v;

class AuthController extends BaseController
{
    public function loginAction($reqMethod)
    {
        if ($reqMethod->getMethod() == 'POST') {
            $validator = v::key('email', v::stringType()->notEmpty())
                ->key('password', v::stringType()->notEmpty());
            try {
                $validator->assert($reqMethod->getParsedBody());
                $user = Usuario::where('email', $reqMethod->getParsedBody()['email'])->first();
                if ($user && $reqMethod->getParsedBody()['password'] === $user->password) {
                    $_SESSION['user'] = $user->name; // O el campo que corresponda
                    $_SESSION['perfil'] = 'usuario';
                    header('Location: /');
                    exit();
                } else {
                    // Aquí asignas el error correctamente
                    $data['error'] = 'Usuario o contraseña incorrectos';
                }
                
            } catch (\Exception $e) {
                // Aquí asignas el error correctamente
                $data['error'] = 'Error: ' . $e->getMessage();
            }
        } else {
            return $this->renderHTML('login.twig');
        }
    
        // Asegúrate de pasar los datos a la vista
        return $this->renderHTML('login.twig', $data);
    }
    
    public function logoutAction()
    {
        session_start();
        session_destroy();
        session_abort();
        session_unset();
        header('Location: /');
    }
}
