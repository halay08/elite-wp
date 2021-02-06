# Elite

A Wordpress site using for Elite Work landing page

## Prerequisites

- **Docker**. Follow the Docker document at [Offical Docker site](https://docs.docker.com/ "Docker document") guide.
- **Lando**. A tool to specify and painlessly spin up the services and tooling needed to develop. Download & Install [Lando](https://docs.lando.dev/basics/installation.html).

## Installation

### System Requirements

This application uses Lando. So here are some basic guidelines to ensure your Lando experience is as smooth as possible.

### Operating System

- macOS 10.13 or later
- Windows 10 Pro+ or equivalent (eg Windows 10 Enterprise) with [Hyper-V running](https://msdn.microsoft.com/en-us/virtualization/hyperv_on_windows/quick_start/walkthrough_install)
- Linux with kernel version 4.x or higher

### Docker Engine Requirements

Please also verify you meet the requirements needed to run our Docker engine backend. Note that the macOS and Windows Lando installer will install Docker for you if needed.

- Linux Docker engine [requirements](https://docs.docker.com/engine/installation/linux)
- Docker for Mac [requirements](https://docs.docker.com/docker-for-mac/#/what-to-know-before-you-install)
- Docker for Windows [requirements](https://docs.docker.com/docker-for-windows/#/what-to-know-before-you-install)

## Setup Environment

Clone source code from GIT repository.

Download & Install [Lando](https://docs.lando.dev/basics/installation.html)

```sh
$ cp wp-config-local-sample.php wp-config-local.php
$ cp .env.example .env
```

```sh
$ lando rebuild -y
```

```sh
$ cd /path/to/project
$ lando start
```

## Development

### PHP Coding Standards

> Follow Wordpress PHP Coding standards at [Wordpress offical site](https://make.wordpress.org/core/handbook/best-practices/coding-standards/php/)

### Some other Coding Standards

- [HTML](https://make.wordpress.org/core/handbook/best-practices/coding-standards/html/)
- [CSS](https://make.wordpress.org/core/handbook/best-practices/coding-standards/css/)
- [Javascript](https://make.wordpress.org/core/handbook/best-practices/coding-standards/javascript/)

### Lando commands

> See [lando command example](https://github.com/lando/lando/blob/master/examples/wordpress/README.md)

Access to appserver service:

```sh
$ lando ssh
```

Use [WP-CLI](https://wp-cli.org/):

```sh
$ lando wp <command>
# Ex. lando wp theme activate unlimited_v2
```

Destroy the Lando application:

```sh
$ lando destroy
```

Rebuild services:

```sh
$ lando rebuild -y
```

This command will also run the bash script [post-build](./scripts/post-build.sh).

Start/Stop/Restart lando

```sh
# Start all services
$ lando start

# Stop all services
$ lando stop

# Restart all services
$ lando restart
```

See lando all services' info (ex: database host, appserver endppoint, etc.):

```sh
$ lando info
```

## Deployment

## Troubleshooting