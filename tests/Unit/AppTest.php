<?php
/**
 * This file is part of the Phalcon Kit.
 *
 * (c) Phalcon Kit team
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tests\Unit;

use App\Bootstrap;
use App\Config\Config;
use Phalcon\Dispatcher\AbstractDispatcher;
use PhalconKit\Exception\CliException;

class AppTest extends AbstractUnit
{
    public function getDispatcher(): AbstractDispatcher
    {
        return $this->bootstrap->di->get('dispatcher');
    }
    
    public function runMvcModule(string $requestUri)
    {
        $_SERVER['REQUEST_URI'] = $requestUri;
        $this->bootstrap = new Bootstrap(\PhalconKit\Bootstrap::MODE_MVC);
        $this->bootstrap->run();
    }
    
    public function runCliModule(array $argv)
    {
        $_SERVER['argv'] = $argv;
        $this->bootstrap = new Bootstrap(\PhalconKit\Bootstrap::MODE_CLI);
        $this->bootstrap->run();
    }
    
    public function testApp(): void
    {
        $this->assertInstanceOf(Config::class, $this->getConfig());
        $this->assertInstanceOf(Bootstrap::class, $this->bootstrap);
    }
    
    public function testDefaultModule(): void
    {
        $this->runMvcModule('/');
        $this->assertEquals('frontend', $this->getDispatcher()->getModuleName());
    }
    
    public function testModuleFrontend(): void
    {
        $this->runMvcModule('/frontend/');
        $this->assertEquals('frontend', $this->getDispatcher()->getModuleName());
    }
    
    public function testModuleAdmin(): void
    {
        $this->runMvcModule('/admin/');
        $this->assertEquals('admin', $this->getDispatcher()->getModuleName());
    }
    
    public function testModuleApi(): void
    {
        $this->runMvcModule('/api/');
        $this->assertEquals('api', $this->getDispatcher()->getModuleName());
    }
    
//    public function testModuleCli(): void
//    {
//        $this->expectException(CliException::class);
//        $this->runCliModule(['zemit', 'cli', 'cron', 'run']);
//        $this->assertEquals('cli', $this->getDispatcher()->getModuleName());
//    }
}
