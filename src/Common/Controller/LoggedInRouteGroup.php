<?php

namespace Juancrrn\Carrier\Common\Controller;

use Juancrrn\Carrier\Common\App;
use Juancrrn\Carrier\Common\Controller\Controller;
use Juancrrn\Carrier\Common\Controller\RouteGroupModel;
use Juancrrn\Carrier\Common\View\Self\ProfileView;
use Juancrrn\Carrier\Domain\StaticForm\Auth\LogoutForm;

/**
 * Logged-in route group
 * 
 * @package carrier
 *
 * @author juancrrn
 *
 * @version 0.0.1
 */

class LoggedInRouteGroup implements RouteGroupModel
{

    private $controllerInstance;

    public function __construct(Controller $controllerInstance)
    {
        $this->controllerInstance = $controllerInstance;
    }

    public function runAll(): void
    {
        $viewManager = App::getSingleton()->getViewManagerInstance();
        
        // Logout (form POST)
        $this->controllerInstance->post('/auth/logout/', function () use ($viewManager) {
            (new LogoutForm('/auth/logout/'))->handle();
        });
        
        // Profile
        $this->controllerInstance->get('/self/profile/', function () use ($viewManager) {
            $viewManager->render(new ProfileView);
        });
    }
}