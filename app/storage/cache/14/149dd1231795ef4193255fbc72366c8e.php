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

/* pages/register.twig */
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
        $this->parent = $this->loadTemplate("/partials/common.twig", "pages/register.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_main($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 3
        echo "    <div class=\"panel\">
        <h2>Register</h2>
        <form action=\"./register.php\" method=\"post\" novalidate>
            <div class=\"form\">
                <label for=\"firstName\">First Name</label>
                <input type=\"text\" name=\"firstName\" id=\"firstName\" value=\"";
        // line 8
        echo twig_escape_filter($this->env, ($context["firstName"] ?? null), "html", null, true);
        echo "\" required>
                ";
        // line 9
        if (twig_get_attribute($this->env, $this->source, ($context["errors"] ?? null), "firstName", [], "any", false, false, false, 9)) {
            // line 10
            echo "                <p class=\"errorMsg\">";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["errors"] ?? null), "firstName", [], "any", false, false, false, 10), "html", null, true);
            echo "</p>
                ";
        }
        // line 12
        echo "                <label for=\"lastName\">Last Name</label>
                <input type=\"text\" name=\"lastName\" id=\"lastName\" value=\"";
        // line 13
        echo twig_escape_filter($this->env, ($context["lastName"] ?? null), "html", null, true);
        echo "\" required>
                ";
        // line 14
        if (twig_get_attribute($this->env, $this->source, ($context["errors"] ?? null), "lastName", [], "any", false, false, false, 14)) {
            // line 15
            echo "                <p class=\"errorMsg\">";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["errors"] ?? null), "lastName", [], "any", false, false, false, 15), "html", null, true);
            echo "</p>
                ";
        }
        // line 17
        echo "                <label for=\"email\">Email</label>
                <input type=\"email\" name=\"email\" id=\"email\" value=\"";
        // line 18
        echo twig_escape_filter($this->env, ($context["email"] ?? null), "html", null, true);
        echo "\" required>
                ";
        // line 19
        if (twig_get_attribute($this->env, $this->source, ($context["errors"] ?? null), "email", [], "any", false, false, false, 19)) {
            // line 20
            echo "                <p class=\"errorMsg\">";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["errors"] ?? null), "email", [], "any", false, false, false, 20), "html", null, true);
            echo "</p>
                ";
        }
        // line 22
        echo "                <label for=\"password\">Password</label>
                <input type=\"password\" name=\"password\" id=\"password\" required>
                ";
        // line 24
        if (twig_get_attribute($this->env, $this->source, ($context["errors"] ?? null), "password", [], "any", false, false, false, 24)) {
            // line 25
            echo "                <p class=\"errorMsg\">";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["errors"] ?? null), "password", [], "any", false, false, false, 25), "html", null, true);
            echo "</p>
                ";
        }
        // line 27
        echo "                <input type=\"hidden\" name=\"moduleAction\" value=\"register\">
            </div>
            <button class=\"btn\" type=\"submit\">Register</button>
        </form>
    </div>
";
    }

    public function getTemplateName()
    {
        return "pages/register.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  111 => 27,  105 => 25,  103 => 24,  99 => 22,  93 => 20,  91 => 19,  87 => 18,  84 => 17,  78 => 15,  76 => 14,  72 => 13,  69 => 12,  63 => 10,  61 => 9,  57 => 8,  50 => 3,  46 => 2,  35 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "pages/register.twig", "/var/www/resources/templates/pages/register.twig");
    }
}
