<?php

namespace App\Controller;

use Psr\Container\ContainerInterface;

class Controller {

    protected $container;

    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }

    public function render($template, $args = []) {
        return $this->container->get('twig')->render($template, $args);
    }

    public function validator() {
        return $this->container->get('validator');
    }

    public function flash() {
        return $this->container->get('flash');
    }

    public function mailer() {
        return $this->container->get('mailer');
    }

    public function logger() {
        return $this->container->get('logger');
    }
}