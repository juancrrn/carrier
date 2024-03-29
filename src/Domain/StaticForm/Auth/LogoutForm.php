<?php

/**
 * Logout form
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

class LogoutForm extends StaticFormModel
{

    private const FORM_ID = 'form-logout';

    public function __construct(string $action)
    {
        parent::__construct(self::FORM_ID, array('action' => $action));

        $this->forceDisableCsrfValidation();
    }
    
    protected function generateFields(array & $preloadedData = array()): string
    {
        return App::getSingleton()->getViewManagerInstance()->fillTemplate(
            'forms/auth/inputs_logout_form',
            array()
        );
    }
    
    protected function process(array & $datos): void
    {
        $app = App::getSingleton();

        $app->getSessionManagerInstance()->doLogOut();

        $app->getViewManagerInstance()->addSuccessMessage('Se ha cerrado la sesión correctamente.', '');
    }
}