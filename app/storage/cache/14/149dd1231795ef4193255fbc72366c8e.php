<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* /pages/register.twig */
class __TwigTemplate_6857fe84803a59e2bbd19ee0e4e8dc41 extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'main' => [$this, 'block_main'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return "/partials/common.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        $this->parent = $this->loadTemplate("/partials/common.twig", "/pages/register.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_main($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 3
        echo "    <div class=\"panel\">
        <h2>Register</h2>
        <form action=\".php\" method=\"post\">
            <div class=\"form\">
                <label for=\"firstName\">First Name</label>
                <input type=\"text\" name=\"firstName\" id=\"firstName\">
                <label for=\"lastName\">Last Name</label>
                <input type=\"text\" name=\"lastName\" id=\"lastName\">
                <label for=\"email\">Email</label>
                <input type=\"email\" name=\"email\" id=\"email\">
                <label for=\"password\">Password</label>
                <input type=\"password\" name=\"password\" id=\"password\">
            </div>
            <button class=\"btn\" type=\"submit\">Register</button>
        </form>
    </div>
";
    }

    public function getTemplateName()
    {
        return "/pages/register.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  50 => 3,  46 => 2,  35 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "/pages/register.twig", "/var/www/resources/templates/pages/register.twig");
    }
}
