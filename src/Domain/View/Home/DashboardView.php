<?php 

namespace Juancrrn\Carrier\Common\View\Home;

use Carrier\Common\App;
use Carrier\Common\View\ViewModel;

/**
 * Dashboard (logged-in home) view
 * 
 * @package carrier
 *
 * @author juancrrn
 *
 * @version 0.0.1
 */

class DashboardView extends ViewModel
{

    private const VIEW_RESOURCE_FILE    = 'views/home/view_dashboard';
    public  const VIEW_NAME             = 'Inicio';
    public  const VIEW_ID               = 'dashboard';
    public  const VIEW_ROUTE            = '/?';

    public function __construct()
    {
        $this->name = self::VIEW_NAME;
        $this->id = self::VIEW_ID;
    }

    public function processContent(): void
    {
        $app = App::getSingleton();

        $filling = array(
            'app-name' => $app->getName(),
            'app-url' => $app->getUrl()
        );

        $app->getViewManagerInstance()->renderTemplate(self::VIEW_RESOURCE_FILE, $filling);
    }
}