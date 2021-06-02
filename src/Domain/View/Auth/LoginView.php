<?php

namespace Juancrrn\Carrier\Common\View\Auth;

use Carrier\Common\App;
use Carrier\Common\View\ViewModel;
use Juancrrn\Carrier\Domain\StaticForm\Auth\LoginForm;

/**
 * Login view
 *
 * @package carrier
 * 
 * @author juancrrn
 *
 * @version 0.0.1
 */

class LoginView extends ViewModel
{
    private const VIEW_RESOURCE_FILE    = 'views/auth/view_login';
    public  const VIEW_NOMBRE           = 'Iniciar sesión';
    public  const VIEW_ID               = 'auth-login';
    public  const VIEW_ROUTE            = '/auth/login/';

    private $form;

    public function __construct()
    {
        App::getSingleton()->getSessionManagerInstance()->requireNotLoggedIn();

        $this->name = self::VIEW_NOMBRE;
        $this->id = self::VIEW_ID;

        $this->form = new LoginForm('/auth/login/'); 

        $this->form->handle();
        $this->form->initialize();
    }

    public function processContent(): void
    {
        $app = App::getSingleton();

        $filling = [
            'form-html' => $this->form->getHtml(),
            'reset-url' => $app->getUrl() . PasswordResetRequestView::VIEW_ROUTE
        ];

        $app->getViewManagerInstance()->renderTemplate(self::VIEW_RESOURCE_FILE, $filling);
    }
}