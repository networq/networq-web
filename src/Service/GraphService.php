<?php

namespace App\Service;

use Networq\Loader\GraphLoader;
use App\Model\GraphDefinition;
use Symfony\Component\Yaml\Yaml;

class GraphService
{
    protected $graph;
    protected $loader;
    protected $index = []; // array of GraphDefinition objects
    protected $twig;

    public function __construct(\Twig_Environment $twig)
    {
        $this->twig = $twig;

        $this->loader = new GraphLoader();

        $filename = getenv('NETWORQ_GRAPH') . '/package.yaml';
        $this->graph = $this->loader->load($filename);
        $this->graph->registerTwig($this->twig);
    }

    public function getGraph()
    {
        return $this->graph;
    }
}
