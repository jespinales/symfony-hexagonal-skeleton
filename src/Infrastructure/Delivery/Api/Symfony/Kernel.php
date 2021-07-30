<?php


namespace App\Infrastructure\Delivery\Api\Symfony;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    public function registerBundles(): iterable
    {
        $contents = require $this->getProjectDir() . '/config/bundles.php';
        foreach ($contents as $class => $envs) {
            if ($envs[$this->environment] ?? $envs['all'] ?? false) {
                yield new $class();
            }
        }
    }

    public function getProjectDir(): string
    {
        return __DIR__;
    }

    protected function configureContainer(ContainerConfigurator $c): void
    {
        $c->import($this->getProjectDir() . '/config/{packages}/*.yaml');
        $c->import($this->getProjectDir() . '/config/{packages}/'.$this->environment.'/*.yaml');

        if (is_file($this->getProjectDir() .'/config/services.yaml')) {
            $c->import($this->getProjectDir() . '/config/services.yaml');
            $c->import($this->getProjectDir() . '/config/{services}_'.$this->environment.'.yaml');
        } elseif (is_file($path = $this->getProjectDir() . '/config/services.php')) {
            (require $path)($c->withPath($path), $this);
        }
    }

    protected function configureRoutes(RoutingConfigurator $routes): void
    {
        $routes->import($this->getProjectDir(). '/config/{routes}/'.$this->environment.'/*.yaml');
        $routes->import($this->getProjectDir() . '/config/{routes}/*.yaml');

        if (is_file($this->getProjectDir() . '/config/routes.yaml')) {
            $routes->import($this->getProjectDir() . '/config/routes.yaml');
        } elseif (is_file($path = $this->getProjectDir() . '/config/routes.php')) {
            (require $path)($routes->withPath($path), $this);
        }
    }

    // optional, to use the standard Symfony cache directory
    public function getCacheDir(): string
    {
        return $this->getProjectDir() . '/var/cache/'.$this->getEnvironment();
    }

    // optional, to use the standard Symfony logs directory
    public function getLogDir(): string
    {
        return $this->getProjectDir() . '/var/log';
    }
}