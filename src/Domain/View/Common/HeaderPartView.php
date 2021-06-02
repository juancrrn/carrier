<?php 

namespace Juancrrn\Carrier\Common\View\Common;

use Juancrrn\Carrier\Common\App;
use Juancrrn\Carrier\Common\View\Auth\LoginView;
use Juancrrn\Carrier\Common\View\Home\DashboardView;
use Juancrrn\Carrier\Common\View\ViewModel;
use Juancrrn\Carrier\Common\View\Home\HomeView;
use Juancrrn\Carrier\Common\View\Self\ProfileView;
use Juancrrn\Carrier\Domain\StaticForm\Auth\LogoutForm;

/**
 * Special header part view
 * 
 * @package carrier
 *
 * @author juancrrn
 *
 * @version 0.0.1
 */

class HeaderPartView extends ViewModel
{

    private const VIEW_RESOURCE_FILE = 'views/common/view_part_header';

    public function __construct()
    {
    }

    public function processContent(): void
    {
        $app = App::getSingleton();

        $sessionManager = $app->getSessionManagerInstance();
        $viewManager = $app->getViewManagerInstance();

        $mainMenuBuffer = '';

        // Generate left menu (main menu) items

        if ($sessionManager->isLoggedIn()) {
            $user = $sessionManager->getLoggedInUser();

            $mainMenuBuffer .= $viewManager->generateMainMenuLink(DashboardView::class);
        } else {
            $mainMenuBuffer .= $viewManager->generateMainMenuLink(HomeView::class);
        }

        // Generate right menu (user menu) items

        $userMenuBuffer = ''; 

        if ($sessionManager->isLoggedIn()) {
            $logoutForm = new LogoutForm('/auth/logout/');
            $logoutForm->handle();
            $logoutForm->initialize();

            $user = $sessionManager->getLoggedInUser();
            
            $fullName = $user->getFullName();

            $profileUrl = $app->getUrl() . '/self/profile/';

            $profileLinkActive =
                $viewManager->getCurrentRenderingView() instanceof ProfileView ?
                'active' : '';
            $userMenuBuffer .= $viewManager->generateUserMenuItem(
                '<a class="nav-link ' . $profileLinkActive . '" href="' . $profileUrl . '">' . $fullName . '</a>'
            );
            $userMenuBuffer .= $viewManager->generateUserMenuItem($logoutForm->getHtml());
        } else {
            $loginUrl = $app->getUrl() . '/auth/login/';

            $userMenuBuffer .= $viewManager->generateUserMenuItem("<a class=\"nav-link\" href=\"$loginUrl\">Iniciar sesión</a>", LoginView::class);
        }

        $filling = array(
            'app-name' => $app->getName(),
            'current-page-name' => $viewManager->getCurrentPageName(),
            'current-page-id' => $viewManager->getCurrentPageId(),
            'app-url' => $app->getUrl(),
            'cache-version' => (! $app->isDevMode()) ? '' : '?v=0.0.0' . time(),
            'main-menu-items' => $mainMenuBuffer,
            'user-menu-items' => $userMenuBuffer
        );

        $app->getViewManagerInstance()->renderTemplate(self::VIEW_RESOURCE_FILE, $filling);
    }
}