<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\GraphService;

class AppController extends AbstractController
{
    protected $graphService;

    public function __construct(GraphService $graphService)
    {
        $this->graphService = $graphService;
    }

    /**
     * @Route("/", name="frontpage")
     */
    public function graph()
    {
        $graph = $this->graphService->getGraph();
        $data = [
            'graph' => $graph,
        ];
        return $this->render('graph.html.twig', $data);
    }

    /**
     * @Route("/types/{fqtn}", name="type")
     */
    public function typeView($fqtn)
    {
        $graph = $this->graphService->getGraph();
        $type = $graph->getType($fqtn);
        $data = [
            'type' => $type,
            'graph' => $graph,
        ];
        return $this->render('type.html.twig', $data);
    }

    /**
     * @Route("/nodes/{fqnn}", name="node")
     */
    public function node($fqnn)
    {
        $graph = $this->graphService->getGraph();
        $node = $graph->getNode($fqnn);

        $widgets = [
            'properties' => $graph->getNodeWidgets($node, 'properties'),
            'tabs' => $graph->getNodeWidgets($node, 'tabs'),
        ];

        $data = [
            'node' => $node,
            'graph' => $graph,
            'widgets' => $widgets,
        ];

        $filename = 'node.html.twig';
        return $this->render($filename, $data);
    }

    /**
     * @Route("/packages/{fqpn}", name="package")
     */
    public function package($fqpn)
    {
        $graph = $this->graphService->getGraph();
        $package = $graph->getPackage($fqpn);
        $data = [
            'package' => $package,
            'graph' => $graph,
        ];
        return $this->render('package.html.twig', $data);
    }

    /**
     * @Route("/packages/{fqpn}/readme", name="package_readme")
     */
    public function packageReadme($fqpn)
    {
        $graph = $this->graphService->getGraph();
        $package = $graph->getPackage($fqpn);
        $data = [
            'package' => $package,
            'graph' => $graph,
        ];
        $response = $this->render('package-readme.html.twig', $data);
        $response->headers->set('Content-Type', 'text/plain');

        return $response;
    }

}
