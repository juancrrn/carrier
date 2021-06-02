<?php 

namespace Juancrrn\Carrier\Common;

use Juancrrn\Carrier\Common\Api\ApiManager;
use Juancrrn\Carrier\Common\SessionManager;
use Juancrrn\Carrier\Common\Controller\Controller;
use Juancrrn\Carrier\Common\View\ViewManager;

/**
 * App initialization and general functionality
 * 
 * @package carrier
 *
 * @author juancrrn
 *
 * @version 0.0.1
 */

class App
{
    
    /**
     * @var string $instance                        Instancia actual de la
     *                                              aplicación.
     */
    private static $instance;
    
    /**
     * @var SessionManager $sessionManagerInstance  Instancia actual del gestor
     *                                              de sesión.
     */
    private $sessionManagerInstance;
    
    /**
     * @var Controller $controllerInstance          Instancia actual del
     *                                              controlador HTTP.
     */
    private $controllerInstance;

    /**
     * @var ViewManager $viewManagerInstance        Instancia actual del gestor
     *                                              de vistas.
     */
    private $viewManagerInstance;

    /**
     * @var ApiManager $apiManagerInstance          Instancia actual del gestor
     *                                              de API.
     */
    private $apiManagerInstance;

    /**
     * @var \mysqli $dbConn             Database connection instance
     */
    private $dbConn;

    /**
     * @var array $dbCredentials        Database credentials
     */
    private $dbCredentials;

    /**
     * @var string $root                Installation root directory
     * @var string $url                 Public URL
     * @var string $pathBase            Public URL path base for controller
     * @var string $nombre              App name
     */
    private $root;
    private $url;
    private $pathBase;
    private $name;
    
    /**
     * @var bool $devMode               Dev mode
     */
    private $devMode;

    /**
     * @var array $emailSettings        Email settings
     */
    private $emailSettings;

    /**
     * @var array $additionalSettings   Additional settings
     */
    private $additionalSettings;

    /**
     * Constructor. Al ser privado, asegura que solo habrá una única instancia
     * de la clase (patrón singleton).
     */
    private function __construct()
    {
    }

    /**
     * Evita que se pueda utilizar el operador clone.
     */
    public function __clone()
    {
        throw new \Exception("Cloning not allowed.");
    }

    /**
     * Evita que se pueda utilizar serialize().
     */
    public function __sleep()
    {
        throw new \Exception("Serializing not allowed.");
    }

    /**
     * Evita que se pueda utilizar unserialize().
     */
    public function __wakeup()
    {
        throw new \Exception("Deserializing not allowed.");
    }

    /**
     * Instanciar la aplicación.
     */
    public static function getSingleton(): self
    {
        if (! self::$instance instanceof self) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * Inicializar la instancia.
     */
    public function init(
        array $dbCredentials,

        string $root,
        string $url,
        string $pathBase,
        string $name,

        bool $devMode,

        array $emailSettings,

        array $additionalSettings
    ): void
    {
        $this->dbConn = null;

        $this->dbCredentials = $dbCredentials;

        $this->root = $root;
        $this->url = $url;
        $this->pathBase = $pathBase;
        $this->name = $name;

        $this->devMode = $devMode;

        $this->emailSettings = $emailSettings;

        $this->additionalSettings = $additionalSettings;

        // Inicializar gestión de la sesión de usuario.
        $this->sessionInstance = new SessionManager;
        $this->sessionInstance->init();

        // Inicializar la gestión del controlador HTTP.
        $this->controllerInstance = new Controller($pathBase);
        
        // Inicializar la gestión de vistas.
        $this->viewManagerInstance = new ViewManager;
        
        // Inicializar la gestión de API.
        $this->apiManagerInstance = new ApiManager;
    }

    /**
     * Inicia una conexión con la base de datos.
     */
    public function getDbConn(): \mysqli
    {
        if (! $this->dbConn) {
            $host = $this->dbCredentials['host'];
            $user = $this->dbCredentials['user'];
            $password = $this->dbCredentials['password'];
            $name = $this->dbCredentials['name'];

            try {
                $this->dbConn = new \mysqli($host, $user, $password, $name);
            } catch (\mysqli_sql_exception $e) {
                throw new \Exception('Error al conectar con la base de datos.', 0, $e);
            }

            try {
                $this->dbConn->set_charset("utf8mb4");
            } catch (\mysqli_sql_exception $e) {
                throw new \Exception('Error al configurar la codificación de la base de datos.', 1);
            }
        }

        return $this->dbConn;
    }

    /*
     *
     * Getters de las propiedades de la instancia
     * 
     */

    public function getSessionManagerInstance(): SessionManager
    {
        return $this->sessionInstance;
    }

    public function getControllerInstance(): Controller
    {
        return $this->controllerInstance;
    }

    public function getViewManagerInstance(): ViewManager
    {
        return $this->viewManagerInstance;
    }

    public function getApiManagerInstance(): ApiManager
    {
        return $this->apiManagerInstance;
    }

    public function getRoot(): string
    {
        return $this->root;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getPathBase(): string
    {
        return $this->pathBase;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function isDevMode(): bool
    {
        return $this->devMode;
    }

    public function getEmailSettings(): array
    {
        return $this->emailSettings;
    }

    public function getAdditionalSettings(): array
    {
        return $this->additionalSettings;
    }

    public function getAdditionalSetting(mixed $key): mixed
    {
        return $this->additionalSettings[$key];
    }
}