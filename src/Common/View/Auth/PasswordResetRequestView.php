<?php

namespace Juancrrn\Carrier\Common\View\Auth;

use Juancrrn\Carrier\Common\App;
use Juancrrn\Carrier\Common\View\ViewModel;
use Juancrrn\Carrier\Domain\StaticForm\Auth\LoginForm;
use Juancrrn\Carrier\Domain\StaticForm\Auth\PasswordResetRequestForm;

/**
 * Password reset request view
 *
 * @package carrier
 * 
 * @author juancrrn
 *
 * @version 0.0.1
 */

class PasswordResetRequestView extends ViewModel
{
    private const VIEW_RESOURCE_FILE    = 'views/auth/view_password_reset_request';
    public  const VIEW_NOMBRE           = 'Solicitar restablecimiento de contraseña';
    public  const VIEW_ID               = 'auth-password-reset-request';
    public  const VIEW_ROUTE            = '/auth/reset/request/';

    private $form;

    public function __construct()
    {
        App::getSingleton()->getSessionManagerInstance()->requireNotLoggedIn();

        $this->name = self::VIEW_NOMBRE;
        $this->id = self::VIEW_ID;

        $this->form = new PasswordResetRequestForm('/auth/reset/request/'); 

        $this->form->handle();
        $this->form->initialize();
    }

    public function processContent(): void
    {
        $app = App::getSingleton();

        $filling = [
            'form-html' => $this->form->getHtml(),
            'login-url' => $app->getUrl() . '/auth/login/'
        ];

        $app->getViewManagerInstance()->renderTemplate(self::VIEW_RESOURCE_FILE, $filling);
    }
}