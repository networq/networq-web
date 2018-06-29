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

### Docker

If you need to override some php.ini settings update _docker/php-fpm/php-override.ini_

To run app in docker run:

    docker-compose up

Server should be usually available under ip 192.168.100.99, you can discover it via command: 

    docker-machine ip

You can run command inside a container using name of service
 
    docker-compose exec php-fpm composer install
    
If you need to add files inside a container update _docker/php-fpm/Dockerfile_

    COPY localPath containerPath

After modifying any service specific settings you need to rebuild it with: 

    docker-compose build php-fpm         
    
### Quick start with example data

You can configure the `NETWORQ_GRAPH` variable in the `.env` file to any valid Networq package.

If you set `NETWORQ_EXAMPLES=true`, it will also load any example nodes found in the `examples/` directory of the root package.

    $ git clone git@github.com:networq/holacracy.git /tmp/holacracy
    $ networq install --path /tmp/holacracy # install dependencies into packages/

Inside docker:

There's no networq executable inside the container (at least yet), 
so you need to copy it to repository folder so container could use it 

    $ docker-compose exec php-fpm git clone https://github.com/networq/holacracy /tmp/holacracy
    $ docker-compose exec php-fpm networq install --path /tmp/holacracy

Now configure `NETWORQ_GRAPH` in `.env` of networq-web to `/tmp/holacracy` and start your server.

You should now be able to browse the example nodes in the holacracy package.

## License

MIT. Please refer to the [license file](LICENSE) for details.

## Brought to you by the LinkORB Engineering team

<img src="http://www.linkorb.com/d/meta/tier1/images/linkorbengineering-logo.png" width="200px" /><br />
Check out our other projects at [linkorb.com/engineering](http://www.linkorb.com/engineering).

Btw, we're hiring!

