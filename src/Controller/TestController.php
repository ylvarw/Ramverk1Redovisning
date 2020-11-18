<?php

namespace Anax\Controller;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

/**
 * A test controller to show off redirect.
 */
class TestController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;



    public function indexAction()
    {
        $page = $this->di->get("page");
        $page->add("anax/v2/article/default", [
            "content" => "HELLO Test controller",
        ]);

        return $page->render();
    }



    public function redirectAction()
    {
        $response = $this->di->get("response");

        return $response->redirect("test");
    }
}
