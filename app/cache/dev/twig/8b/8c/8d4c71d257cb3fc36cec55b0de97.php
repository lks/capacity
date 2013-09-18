<?php

/* LksUserManagementBundle:modules:addUserForm.html.twig */
class __TwigTemplate_8b8c8d4c71d257cb3fc36cec55b0de97 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<form class=\"form-inline\">
  <input type=\"text\" class=\"input-small\" placeholder=\"Firstname\">
  <input type=\"text\" class=\"input-small\" placeholder=\"Lastname\">
  <button type=\"submit\" class=\"btn btn-primary\">Add user</button>
</form>";
    }

    public function getTemplateName()
    {
        return "LksUserManagementBundle:modules:addUserForm.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  19 => 1,);
    }
}
