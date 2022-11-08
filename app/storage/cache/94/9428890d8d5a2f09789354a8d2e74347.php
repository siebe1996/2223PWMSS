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

/* /pages/login.twig */
class __TwigTemplate_004c30c4b21eed7a75819bc9f14161eb extends Template
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
        $this->parent = $this->loadTemplate("/partials/common.twig", "/pages/login.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_main($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 3
        echo "<div class=\"panel\">
    <h2>Log in</h2>
    <form action=\".php\" method=\"post\">
        <div class=\"form\">
            <label for=\"username\">Username</label>
            <input type=\"text\" name=\"username\" id=\"username\">
            <label for=\"password\">Password</label>
            <input type=\"password\" name=\"password\" id=\"password\">
        </div>
        <button class=\"btn\" type=\"submit\">Log In</button>
    </form>
    <a href=\"/php/register.php\">Register here</a> if you don't have an account yet
</div>
";
    }

    public function getTemplateName()
    {
        return "/pages/login.twig";
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
        return new Source("", "/pages/login.twig", "/var/www/resources/templates/pages/login.twig");
    }
}
