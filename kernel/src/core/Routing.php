<?php

namespace Mselyatin\Question\core;

use Mselyatin\Question\core\factory\ErrorFactory;
use Mselyatin\Question\exceptions\ClientErrorException;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Router;
use Exception;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use DomainException;

/**
 * @author <selyatin83@mail.ru>
 */
class Routing
{
    /**
     * Path to a directory with a file of routes.
     * @var string
     */
    private string $yamlPath;

    /**
     * Path to a file of routes
     * @var string
     */
    private string $yamlFile;

    /**
     * @param string $yamlPath
     * @param string $yamlFile
     */
    public function __construct(string $yamlPath, string $yamlFile)
    {
        $this->yamlPath = $yamlPath;
        $this->yamlFile = $yamlFile;
    }

    /**
     * @return JsonResponse
     */
    public function handle(): JsonResponse
    {
        try {
            $fileLocator = new FileLocator(array($this->yamlPath));

            $requestContext = new RequestContext();
            $requestContext->fromRequest(Request::createFromGlobals());

            $router = new Router(
                new YamlFileLoader($fileLocator),
                $this->yamlFile,
                [], //@todo cache dir
                $requestContext
            );

            $parameters = $router->match($requestContext->getPathInfo());

            if (empty($parameters)) {
                throw new ResourceNotFoundException();
            }

            $params = explode('::', $parameters['_controller']);
            $controller = array_shift($params) ?? null;
            $action = array_shift($params) ?? null;

            if ($controller === null || $action === null) {
                throw new DomainException('The controller or action is empty');
            }

            $answer = (new $controller)->$action();
            return $answer instanceof JsonResponse
                ? $answer
                : throw new DomainException('Response type must be JsonResponse');
        } catch (ClientErrorException $e) {
            $message = $e->getMessage() != ''
                ? $e->getMessage()
                : null;

            return ErrorFactory::get(
                $e->getClientCodeError(),
                $message,
                $e->getExtra()
            );
        } catch (ResourceNotFoundException) {
            return ErrorFactory::get(ErrorFactory::PAGE_NOT_FOUND_ERROR);
        } catch (Exception $e) {
            var_dump($e->getMessage());die;
            return ErrorFactory::get(ErrorFactory::SYSTEM_ERROR);
        }
    }
}
