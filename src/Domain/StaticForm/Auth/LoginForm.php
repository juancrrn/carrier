<?php

/**
 * Login form
 * 
 * @package carrier
 *
 * @author juancrrn
 *
 * @version 0.0.1
 */

namespace Juancrrn\Carrier\Domain\StaticForm\Auth;

use Juancrrn\Carrier\Common\App;
use Juancrrn\Carrier\Domain\StaticForm\StaticFormModel;
use Juancrrn\Carrier\Domain\User\User;
use Juancrrn\Carrier\Domain\User\UserRepository;

class LoginForm extends StaticFormModel
{

    private const FORM_ID = 'form-login';

    public function __construct(string $action)
    {
        parent::__construct(self::FORM_ID, array('action' => $action));
    }
    
    protected function generateFields(array & $preloadedData = array()): string
    {
        $govId = '';

        if (! empty($preloadedData)) {
            $govId = isset($preloadedData['gov_id']) ? $preloadedData['gov_id'] : $govId;
        }

        return App::getSingleton()->getViewManagerInstance()->fillTemplate(
            'forms/auth/inputs_login_form',
            array(
                'gov_id' => $govId
            )
        );
    }
    
    protected function process(array & $postedData): void
    {
        $app = App::getSingleton();
        $view = $app->getViewManagerInstance();

        $userRepository = new UserRepository($app->getDbConn());
        
        $govId = isset($postedData['gov_id']) ? $postedData['gov_id'] : null;

        if (empty($govId)) {
            $view->addErrorMessage('El NIF o NIE no puede estar vacío.');
        } elseif (! $userRepository->findByGovId($govId)) {
            $view->addErrorMessage('El NIF o NIE introducido no existe.');
            $view->addErrorMessage('Aunque las solicitudes están a nombre de los estudiantes, los representantes legales pueden gestionarlas en su nombre. Prueba a utilizar el NIF o NIE de un representante para acceder.');
        }
        
        $password = isset($postedData['password']) ? $postedData['password'] : null;
        
        if (empty($password)) {
            $view->addErrorMessage('La contraseña no puede estar vacía.');
        }

        // Si no hay ningún error, continuar.
        if (! $view->anyErrorMessages()) {
            $userId = $userRepository->findByGovId($govId);

            // Comprobar que el usuario está activado
            $user = $userRepository->retrieveById($userId, true);

            if ($user->getStatus() != User::STATUS_ACTIVE) {
                $view->addErrorMessage('Tu usuario no está activado. Busca un mensaje en tu bandeja de entrada de correo electrónico con un enlace para activarlo o restablecer tu contraseña.');
                $view->addErrorMessage('Por favor, comprueba tu bandeja de correo no deseado o spam. Si no encuentras el mensaje, puedes contactar con nosotros.');
            } else {

                // Comprobar si la contraseña es correcta.
                if (! password_verify($password, $userRepository->retrieveJustHashedPasswordById($userId))) {
                    $view->addErrorMessage('El NIF o NIE y la contraseña introducidos no coinciden.');
                } else {
                    $sessionManager = $app->getSessionManagerInstance();

                    $sessionManager->doLogIn($user);

                    $userRepository->updateLastLoginDateById($userId);

                    $view->addSuccessMessage('¡Te damos la bienvenida!', '');
                }
            }
        }

        $this->initialize();
    }
}