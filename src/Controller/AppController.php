<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
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
     * @Route("/search", name="search")
     */
    public function search(Request $request)
    {
        $graph = $this->graphService->getGraph();
        $query = strtolower($request->request->get('query'));
        $nodes = $graph->getNodes();
        $res = [];
        foreach ($nodes as $node) {
            if ($node->hasTag('networq:core:node')) {
                $name = strtolower($node['networq:core:node']['name']);
                if (strpos($name, $query) !== false) {
                    $res[] = $node;
                }
            }
        }
        $data = [
            'graph' => $graph,
            'nodes' => $res,
        ];
        return $this->render('search.html.twig', $data);
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
     * @Route("/nodes/new", name="node_new")
     */
    public function nodeNew(Request $request, SessionInterface $session)
    {
        $graph = $this->graphService->getGraph();
        if ($request->getMethod()=='POST') {
            $name = $request->request->get('node_name');
            $name = strtolower(trim($name));
            $fqnn = $graph->getRootPackage()->getFqpn() . ':' . $name;

            if ($graph->hasNode($fqnn)) {
                $this->get('session')->getFlashBag()->add(
                    'warning',
                    'A node with this name already exists: <a href="/nodes/' . $fqnn . '">' . $fqnn . '</a>'
                );
                return $this->redirectToRoute('node_new', ['name' => $name]);
            }

            $yaml = '';
            $graph->persist($fqnn, $yaml);
            return $this->redirectToRoute('node_yaml', ['fqnn' => $fqnn]);
        }


        $types = $graph->getTypes(); // for inline help?
        $data = [
            'graph' => $graph,
            'types' => $types,
        ];

        $filename = 'node_new.html.twig';
        return $this->render($filename, $data);
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
     * @Route("/nodes/{fqnn}/edit", name="node_edit")
     */
    public function nodeEdit($fqnn)
    {
        $graph = $this->graphService->getGraph();
        $node = $graph->getNode($fqnn);

        // $widgets = [
        //     'properties' => $graph->getNodeWidgets($node, 'properties'),
        //     'tabs' => $graph->getNodeWidgets($node, 'tabs'),
        // ];
        $types = $graph->getTypes();

        $data = [
            'node' => $node,
            'graph' => $graph,
            'types' => $types,
        ];

        $filename = 'node_edit.html.twig';
        return $this->render($filename, $data);
    }

    /**
     * @Route("/nodes/{fqnn}/yaml", name="node_yaml")
     */
    public function nodeYaml(Request $request, $fqnn)
    {
        $graph = $this->graphService->getGraph();
        if ($request->getMethod()=='POST') {
            $yaml = $request->request->get('yaml');
            $graph->persist($fqnn, $yaml);
            return $this->redirectToRoute('node', ['fqnn' => $fqnn]);
        }
        $yaml = null;
        if ($graph->hasNode($fqnn)) {
            $yaml = $graph->getNodeYaml($fqnn);
        }


        $types = $graph->getTypes(); // for inline help?
        $data = [
            'fqnn' => $fqnn,
            'graph' => $graph,
            'types' => $types,
            'yaml' => $yaml,
        ];

        $filename = 'node_yaml.html.twig';
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
