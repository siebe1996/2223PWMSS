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

/* pages/login.twig */
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
        $this->parent = $this->loadTemplate("/partials/common.twig", "pages/login.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_main($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 3
        echo "    <div class=\"panel login\">
        <h2>Log in</h2>
        ";
        // line 5
        if (($context["error"] ?? null)) {
            // line 6
            echo "            <p class=\"errorMsg\">";
            echo twig_escape_filter($this->env, ($context["error"] ?? null), "html", null, true);
            echo "</p>
        ";
        }
        // line 8
        echo "        <form action=\"./login.php\" method=\"post\">
            <input type=\"hidden\" name=\"moduleAction\" value=\"login\">
            <div class=\"form\" id=\"loginForm\">
                <label for=\"email\">E-mail</label>
                <span";
        // line 12
        if (($context["error"] ?? null)) {
            // line 13
            echo "                            class=\"error\"
                        ";
        }
        // line 14
        echo ">
                    <svg width=\"22\" height=\"22\" viewBox=\"0 0 16 16\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\"
                         class=\"username\">
                        <path d=\"M6.5 2C6.36739 2 6.24021 2.05268 6.14645 2.14645C6.05268 2.24021 6 2.36739 6 2.5C6 2.63261 6.05268 2.75979 6.14645 2.85355C6.24021 2.94732 6.36739 3 6.5 3H7.5V13H6.5C6.36739 13 6.24021 13.0527 6.14645 13.1464C6.05268 13.2402 6 13.3674 6 13.5C6 13.6326 6.05268 13.7598 6.14645 13.8536C6.24021 13.9473 6.36739 14 6.5 14H9.5C9.63261 14 9.75979 13.9473 9.85355 13.8536C9.94732 13.7598 10 13.6326 10 13.5C10 13.3674 9.94732 13.2402 9.85355 13.1464C9.75979 13.0527 9.63261 13 9.5 13H8.5V3H9.5C9.63261 3 9.75979 2.94732 9.85355 2.85355C9.94732 2.75979 10 2.63261 10 2.5C10 2.36739 9.94732 2.24021 9.85355 2.14645C9.75979 2.05268 9.63261 2 9.5 2H6.5ZM4 4H6.5V5H4C3.73478 5 3.48043 5.10536 3.29289 5.29289C3.10536 5.48043 3 5.73478 3 6V9.997C3 10.2622 3.10536 10.5166 3.29289 10.7041C3.48043 10.8916 3.73478 10.997 4 10.997H6.5V11.997H4C3.46957 11.997 2.96086 11.7863 2.58579 11.4112C2.21071 11.0361 2 10.5274 2 9.997V6C2 5.46957 2.21071 4.96086 2.58579 4.58579C2.96086 4.21071 3.46957 4 4 4ZM12 10.997H9.5V11.997H12C12.5304 11.997 13.0391 11.7863 13.4142 11.4112C13.7893 11.0361 14 10.5274 14 9.997V6C14 5.46957 13.7893 4.96086 13.4142 4.58579C13.0391 4.21071 12.5304 4 12 4H9.5V5H12C12.2652 5 12.5196 5.10536 12.7071 5.29289C12.8946 5.48043 13 5.73478 13 6V9.997C13 10.2622 12.8946 10.5166 12.7071 10.7041C12.5196 10.8916 12.2652 10.997 12 10.997Z\"
                              fill=\"currentColor\"/>
                    </svg>

                    <input type=\"text\" name=\"email\" id=\"email\"
                        ";
        // line 22
        if (($context["error"] ?? null)) {
            // line 23
            echo "                            class=\"error\"
                        ";
        }
        // line 24
        echo ">
                </span>
                <label for=\"password\">Password</label>
                <span";
        // line 27
        if (($context["error"] ?? null)) {
            // line 28
            echo "                            class=\"error\"
                        ";
        }
        // line 29
        echo ">
                    <svg xmlns=\"http://www.w3.org/2000/svg\" width=\"22px\" height=\"22px\"
                         preserveAspectRatio=\"xMidYMid meet\"
                         viewBox=\"0 0 24 24\" class=\"password\">
                        <path fill=\"currentColor\"
                              d=\"M12 17a2 2 0 0 0 2-2a2 2 0 0 0-2-2a2 2 0 0 0-2 2a2 2 0 0 0 2 2m6-9a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V10a2 2 0 0 1 2-2h1V6a5 5 0 0 1 5-5a5 5 0 0 1 5 5v2h1m-6-5a3 3 0 0 0-3 3v2h6V6a3 3 0 0 0-3-3Z\"/>
                    </svg>
                    <input type=\"password\" name=\"password\" id=\"password\"
                        ";
        // line 37
        if (($context["error"] ?? null)) {
            // line 38
            echo "                            class=\"error\"
                        ";
        }
        // line 39
        echo ">

                </span>
                <button class=\"btn\" type=\"submit\">Log In</button>
            </div>
        </form>
        <p><a href=\"./register.php\">Register here</a> if you don't have an account yet</p>
    </div>
";
    }

    public function getTemplateName()
    {
        return "pages/login.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  117 => 39,  113 => 38,  111 => 37,  101 => 29,  97 => 28,  95 => 27,  90 => 24,  86 => 23,  84 => 22,  74 => 14,  70 => 13,  68 => 12,  62 => 8,  56 => 6,  54 => 5,  50 => 3,  46 => 2,  35 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "pages/login.twig", "/var/www/resources/templates/pages/login.twig");
    }
}
