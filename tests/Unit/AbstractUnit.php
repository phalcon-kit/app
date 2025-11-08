<?php

declare(strict_types=1);

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Phalcon\Autoload\Loader;
use Phalcon\Di\DiInterface;
use PhalconKit\Support\Env;
use PhalconKit\Exception;
use App\Bootstrap;
use App\Config\Config;

/**
 * @coversNothing
 */
abstract class AbstractUnit extends TestCase
{
    protected bool $loaded = false;
    
    protected ?Bootstrap $bootstrap = null;
    
    protected ?DiInterface $di = null;
    
    protected ?Loader $loader = null;
    
    protected string $mode = Bootstrap::MODE_MVC;
    
    public function getConfig(): Config
    {
        return $this->di->get('config');
    }
    
    /**
     * Phalcon Kit Setup
     * @throws Exception
     */
    protected function setUp(): void
    {
        
        $rootDir = dirname(dirname(__DIR__)) . '/';
        defined('APP_PATH') || define('APP_PATH', $rootDir . 'app/');
        Env::setNames(['.env.testing']);
        
        $loader = new Loader();
        $loader->setFiles([$rootDir . '/vendor/autoload.php']);
        $loader->setNamespaces(['App' => $rootDir . '/app']);
        $loader->setFileCheckingCallback(null);
        $loader->register();
        
        $this->bootstrap = new Bootstrap($this->mode);
        $this->di = $this->bootstrap->di;
        $this->loaded = true;
        parent::setUp();
    }
    
    protected function tearDown(): void
    {
        $this->loader = null;
        $this->bootstrap = null;
        $this->di = null;
        $this->loaded = false;
        parent::tearDown();
    }
}
