<?php 

namespace Juancrrn\Carrier\Domain\View\Error;

use Carrier\Common\App;
use Carrier\Common\View\ViewModel;

/**
 * Error 404 view
 * 
 * @package carrier
 *
 * @author juancrrn
 *
 * @version 0.0.1
 */

class Error404View extends ViewModel
{

    private const VIEW_RESOURCE_FILE    = 'views/error/view_error_404';
    public  const VIEW_NAME             = 'Error 404: página no encontrada';
    public  const VIEW_ID               = 'error-404';

    public function __construct()
    {
        $this->name = self::VIEW_NAME;
        $this->id = self::VIEW_ID;
    }

    public function processContent(): void
    {
        $app = App::getSingleton();

        $filling = array();

        $app->getViewManagerInstance()->renderTemplate(self::VIEW_RESOURCE_FILE, $filling);
    }
}