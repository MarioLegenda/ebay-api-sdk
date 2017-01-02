<?php

namespace SDKBuilder\Processor\Factory;

 use FindingAPI\Core\Request\Request;
 use SDKBuilder\Exception\SDKBuilderException;
 use SDKBuilder\Processor\ProcessorInterface;
 use SDKBuilder\Request\AbstractRequest;

 class ProcessorFactory
{
    /**
     * @var array $processors
     */
    private $processors = array();
    /**
     * @param string $method
     * @param string $processor
     * @return ProcessorFactory
     */
    public function registerProcessor(string $method, string $processor) : ProcessorFactory
    {
        $this->processors[$method][] = array(
            'resolver' => $processor,
        );

        return $this;
    }

    public function registerCallbackProcessor(string $method, \Closure $callback)
    {
        $this->processors[$method][] = array(
            'resolver' => $callback,
        );
    }
    /**
     * @param string $method
     * @param string $processor
     * @return ProcessorFactory
     */
    public function unregisterProcessor(string $method, string $processor) : ProcessorFactory
    {
        foreach ($this->processors[$method] as $key => $prc) {
            if ($prc['namespace'] === $processor) {
                unset($this->processors[$method][$key]);
            }
        }

        return $this;
    }
    /**
     * @param AbstractRequest $request
     * @return array
     */
    public function createProcessors(AbstractRequest $request) : array
    {
        $method = $request->getMethod();

        $processors = array();
        foreach ($this->processors[$method] as $key => $processor) {
            $resolver = $processor['resolver'];

            if ($resolver instanceof \Closure) {
                $object = $resolver->__invoke($request);

                if ($object instanceof ProcessorInterface) {
                    $processors[] = $object;
                }
            }

            if (is_string($resolver) and class_exists($resolver)) {
                $object = new $resolver($request);

                if ($object instanceof ProcessorInterface) {
                    $processors[] = $object;
                }
            }
        }

        $this->processors[$method] = array();

        return $processors;

/*        $itemFilters = $this->request->getItemFilterStorage();

        $processors = array();
        $mainNamespace = 'SDKBuilder\Processor\Get\\';

        $requestParametersProcessorClass = $mainNamespace.ucfirst($method).'RequestParametersProcessor';
        $processors['request-parameters-processor'] = new $requestParametersProcessorClass($this->request);

        if (!empty($itemFilters)) {
            $itemFiltersProcessorClass = $mainNamespace.ucfirst($method).'ItemFiltersProcessor';

            $processors['item-filters-processor'] = new $itemFiltersProcessorClass($this->request, $itemFilters);
        }

        return $processors;*/
    }
}