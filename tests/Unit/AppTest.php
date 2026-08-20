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
use App\Config;
use App\Modules\Admin\Controllers\IndexController as AdminIndexController;
use App\Modules\Admin\Module as AdminModule;
use App\Modules\Ws\Module as WsModule;
use App\Modules\Ws\Tasks\MainTask as WsMainTask;
use Phalcon\Dispatcher\AbstractDispatcher;
use PhalconKit\Ws\Router as WsRouter;
use PhalconKit\Ws\WebSocket;

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
    
    public function testModuleApi(): void
    {
        $this->runMvcModule('/api/');
        $this->assertSame('api', $this->getDispatcher()->getModuleName());
    }

    public function testWebSocketConfigurationIsRegisteredSecurely(): void
    {
        $config = $this->getConfig();
        $modules = $config->pathToArray('modules') ?? [];
        $publicComponents = $config->pathToArray('permissions.roles.everyone.components') ?? [];
        $webSocketComponents = $config->pathToArray('permissions.roles.ws.components') ?? [];

        $this->assertSame(AdminModule::class, $modules[AdminModule::NAME_ADMIN]['className'] ?? null);
        $this->assertSame(WsModule::class, $modules[WsModule::NAME_WS]['className'] ?? null);
        $this->assertSame('App\\Modules\\Ws\\Tasks', $config->path('router.ws.namespace'));
        $this->assertSame('127.0.0.1', $config->path('swoole.host'));
        $this->assertArrayNotHasKey(AdminIndexController::class, $publicComponents);
        $this->assertSame(['listen'], $webSocketComponents[WsMainTask::class] ?? null);
    }

    public function testWebSocketExampleProtocol(): void
    {
        $task = new WsMainTask();

        $this->assertSame(['type' => 'pong'], $task->getMessageResponse('{"type":"ping"}'));
        $this->assertSame(
            ['type' => 'error', 'message' => 'Invalid JSON'],
            $task->getMessageResponse('{')
        );
        $this->assertSame(
            ['type' => 'error', 'message' => 'A string message type is required'],
            $task->getMessageResponse('{}')
        );
        $this->assertSame(
            ['type' => 'error', 'message' => 'Unsupported message type'],
            $task->getMessageResponse('{"type":"broadcast"}')
        );
    }

    public function testWebSocketModeBootsWithoutStartingServer(): void
    {
        $this->bootstrap = new Bootstrap(Bootstrap::MODE_WS);
        $this->di = $this->bootstrap->di;
        $webSocket = $this->di->getShared('webSocket');

        $this->assertInstanceOf(WsRouter::class, $this->bootstrap->getRouter());
        $this->assertInstanceOf(WebSocket::class, $webSocket);
        $this->assertArrayHasKey(WsModule::NAME_WS, $webSocket->getModules());
        $this->assertTrue($this->di->has('swoole'));
    }
}
