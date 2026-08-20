<?php

/**
 * This file is part of the Phalcon Kit.
 *
 * (c) Phalcon Kit team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tests\Unit;

use App\Bootstrap;
use App\Config\Config;
use Phalcon\Dispatcher\AbstractDispatcher;

class AppTest extends AbstractUnit
{
    public function getDispatcher(): AbstractDispatcher
    {
        self::assertNotNull($this->di);
        $dispatcher = $this->di->getShared('dispatcher');
        self::assertInstanceOf(AbstractDispatcher::class, $dispatcher);

        return $dispatcher;
    }

    private function runMvcModule(string $requestUri): void
    {
        $_SERVER['REQUEST_URI'] = $requestUri;
        $this->bootstrap = new Bootstrap(Bootstrap::MODE_MVC);
        $this->di = $this->bootstrap->di;
        $this->bootstrap->run();
    }

    public function testApp(): void
    {
        $this->assertInstanceOf(Config::class, $this->getConfig());
        $this->assertInstanceOf(Bootstrap::class, $this->bootstrap);
        $this->assertSame(ROOT_PATH . 'src/', APP_PATH);
    }

    public function testDefaultModule(): void
    {
        $this->runMvcModule('/');
        $this->assertSame('frontend', $this->getDispatcher()->getModuleName());
    }
    
    public function testModuleFrontend(): void
    {
        $this->runMvcModule('/frontend/');
        $this->assertSame('frontend', $this->getDispatcher()->getModuleName());
    }
    
    public function testModuleAdmin(): void
    {
        $this->runMvcModule('/admin/');
        $this->assertSame('admin', $this->getDispatcher()->getModuleName());
    }
    
    public function testModuleApi(): void
    {
        $this->runMvcModule('/api/');
        $this->assertSame('api', $this->getDispatcher()->getModuleName());
    }
}
