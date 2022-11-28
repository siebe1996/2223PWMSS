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
        echo "\" required
                        ";
        // line 9
        if (twig_get_attribute($this->env, $this->source, ($context["errors"] ?? null), "firstName", [], "any", false, false, false, 9)) {
            // line 10
            echo "                            class=\"error\"
                        ";
        }
        // line 11
        echo ">
                ";
        // line 12
        if (twig_get_attribute($this->env, $this->source, ($context["errors"] ?? null), "firstName", [], "any", false, false, false, 12)) {
            // line 13
            echo "                <p class=\"errorMsg\">";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["errors"] ?? null), "firstName", [], "any", false, false, false, 13), "html", null, true);
            echo "</p>
                ";
        }
        // line 15
        echo "                <label for=\"lastName\">Last Name</label>
                <input type=\"text\" name=\"lastName\" id=\"lastName\" value=\"";
        // line 16
        echo twig_escape_filter($this->env, ($context["lastName"] ?? null), "html", null, true);
        echo "\" required
                        ";
        // line 17
        if (twig_get_attribute($this->env, $this->source, ($context["errors"] ?? null), "lastName", [], "any", false, false, false, 17)) {
            // line 18
            echo "                            class=\"error\"
                        ";
        }
        // line 19
        echo ">
                ";
        // line 20
        if (twig_get_attribute($this->env, $this->source, ($context["errors"] ?? null), "lastName", [], "any", false, false, false, 20)) {
            // line 21
            echo "                <p class=\"errorMsg\">";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["errors"] ?? null), "lastName", [], "any", false, false, false, 21), "html", null, true);
            echo "</p>
                ";
        }
        // line 23
        echo "                <label for=\"email\">Email</label>
                <input type=\"email\" name=\"email\" id=\"email\" value=\"";
        // line 24
        echo twig_escape_filter($this->env, ($context["email"] ?? null), "html", null, true);
        echo "\" required
                        ";
        // line 25
        if (twig_get_attribute($this->env, $this->source, ($context["errors"] ?? null), "email", [], "any", false, false, false, 25)) {
            // line 26
            echo "                            class=\"error\"
                        ";
        }
        // line 27
        echo ">
                ";
        // line 28
        if (twig_get_attribute($this->env, $this->source, ($context["errors"] ?? null), "email", [], "any", false, false, false, 28)) {
            // line 29
            echo "                <p class=\"errorMsg\">";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["errors"] ?? null), "email", [], "any", false, false, false, 29), "html", null, true);
            echo "</p>
                ";
        }
        // line 31
        echo "                <label for=\"password\">Password</label>
                <input type=\"password\" name=\"password\" id=\"password\" required
                        ";
        // line 33
        if (twig_get_attribute($this->env, $this->source, ($context["errors"] ?? null), "password", [], "any", false, false, false, 33)) {
            // line 34
            echo "                    class=\"error\"
                        ";
        }
        // line 35
        echo ">
                ";
        // line 36
        if (twig_get_attribute($this->env, $this->source, ($context["errors"] ?? null), "password", [], "any", false, false, false, 36)) {
            // line 37
            echo "                <p class=\"errorMsg\">";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["errors"] ?? null), "password", [], "any", false, false, false, 37), "html", null, true);
            echo "</p>
                ";
        }
        // line 39
        echo "                <input type=\"hidden\" name=\"moduleAction\" value=\"register\">
                <button class=\"btn\" type=\"submit\">Register</button>
            </div>
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
        return array (  147 => 39,  141 => 37,  139 => 36,  136 => 35,  132 => 34,  130 => 33,  126 => 31,  120 => 29,  118 => 28,  115 => 27,  111 => 26,  109 => 25,  105 => 24,  102 => 23,  96 => 21,  94 => 20,  91 => 19,  87 => 18,  85 => 17,  81 => 16,  78 => 15,  72 => 13,  70 => 12,  67 => 11,  63 => 10,  61 => 9,  57 => 8,  50 => 3,  46 => 2,  35 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "pages/register.twig", "/var/www/resources/templates/pages/register.twig");
    }
}
