<?php

namespace App\Logging;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Container\Container;
use Monolog\Logger;

class ChronosLogger {
    private Repository $config;

    public function __construct(Container $container, Repository $config) {
        $this->config = $config;
    }

    public function __invoke(array $config): Logger {
        if(empty($config['url'])) {
            throw new \InvalidArgumentException('The "url" option is required for the ChronosLogger');
        }

        return new Logger($this->config->get('app.name'), [
            new ChronosLogHandler($config)
        ]);
    }
}
