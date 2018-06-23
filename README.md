Web-based Networq Viewer
========================

This is an implementation of a Networq Viewer in PHP (Symfony 4).

It's using the [Networq PHP library](https://github.com/networq/networq-php) for loading and browsing Networq packages, types, nodes, etc.

## Usage

### Installation:

    $ git clone git@github.com:networq/networq-web.git
    $ cd networq-web
    $ composer install
    $ cp .env.dist .env
    $ edit .env # Adjust for your setup

### Starting the server

    $ php -S 0.0.0.0:8080 -t public/

Now open http://localhost:8181/ in a browser to start browsing the graph.

### Quick start with example data

You can configure the `NETWORQ_GRAPH` variable in the `.env` file to any valid Networq package.

If you set `NETWORQ_EXAMPLES=true`, it will also load any example nodes found in the `examples/` directory of the root package.

    $ cd /tmp
    $ git clone git@github.com:networq/holacracy.git
    $ cd holacracy
    $ networq install # install dependencies into packages/

Now configure `NETWORQ_GRAPH` in `.env` of networq-web to `/tmp/holacracy` and start your server.

You should now be able to browse the example nodes in the holacracy package.

## License

MIT. Please refer to the [license file](LICENSE) for details.

## Brought to you by the LinkORB Engineering team

<img src="http://www.linkorb.com/d/meta/tier1/images/linkorbengineering-logo.png" width="200px" /><br />
Check out our other projects at [linkorb.com/engineering](http://www.linkorb.com/engineering).

Btw, we're hiring!

