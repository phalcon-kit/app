<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Bootstrap;
use App\Config\Config;
use Phalcon\Di\Di;
use Phalcon\Di\DiInterface;
use PhalconKit\Exception;
use PhalconKit\Support\Env;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\TestCase;

#[CoversNothing]
abstract class AbstractUnit extends TestCase
{
    protected ?Bootstrap $bootstrap = null;

    protected ?DiInterface $di = null;

    protected string $mode = Bootstrap::MODE_MVC;

    public function getConfig(): Config
    {
        self::assertNotNull($this->di);
        $config = $this->di->getShared('config');
        self::assertInstanceOf(Config::class, $config);

        return $config;
    }

    /**
     * Build an isolated application bootstrap for each test.
     *
     * @throws Exception
     */
    protected function setUp(): void
    {
        parent::setUp();

        Env::$dotenv = null;
        Env::$vars = [];
        Env::setPaths([ROOT_PATH]);
        Env::setNames(['.env.testing']);

        $this->bootstrap = new Bootstrap($this->mode);
        $this->di = $this->bootstrap->di;
    }

    protected function tearDown(): void
    {
        $this->bootstrap = null;
        $this->di = null;
        Di::reset();
        unset($_SERVER['REQUEST_URI'], $_SERVER['argv']);

        parent::tearDown();
    }
}
