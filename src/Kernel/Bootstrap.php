<?php
namespace coffeforme\Kernel;

use coffeforme\Kernel\Database\Database;
use Symfony\Component\Dotenv\Dotenv;

final class Bootstrap
{
    public function __construct()
    {
        $dotenv = new Dotenv();
        $this->loadEnvironmentVariable($dotenv);
        define('DEBUG_MODE', filter_var($_ENV['DEBUG_MODE'], FILTER_VALIDATE_BOOL));

        $this->initializeDebuggingMode();
        $this->initializeDatabase();
    }
    public function run(): void
    {
        require dirname(__DIR__, 1) . '/routes.php';
    }
    private function initializeDebuggingMode()
    {
        // define('DEBUG_MODE', filter_var($_ENV['DEBUG_MODE'], FILTER_VALIDATE_BOOL));
        if (DEBUG_MODE) {
            error_reporting(E_ALL);
            ini_set('display_errors', 'On');
        } else {
            error_reporting(0);
            ini_set('display_errors', 'Off');
        }
    }
    private function initializeDatabase()
    {
        $dbDetails = [
            'db_host' => $_ENV['DB_HOST'],
            'db_name' => $_ENV['DB_NAME'],
            'db_user' => $_ENV['DB_USER'],
            'db_password' => $_ENV['DB_PASSWORD']
        ];
        Database::connect($dbDetails);
    }

    private function loadEnvironmentVariable(Dotenv $dotenv): void
    {
        // $dotenv = new Dotenv();
        $dotenv->load(dirname(__DIR__, 2) . '/.env');
    }
}