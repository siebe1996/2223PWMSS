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

/* /pages/becomeDriver.twig */
class __TwigTemplate_2a1da99e21ddf7153632fec701834993 extends Template
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
        $this->parent = $this->loadTemplate("/partials/common.twig", "/pages/becomeDriver.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_main($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 3
        echo "    <div class=\"panel registerDriver\">
        <h2>Driver Register</h2>
        <form action=\"./becomeDriver.php\" method=\"post\" novalidate>
            <div class=\"form\" id=\"registerDriver\">
                <section class=\"firstFormSection\">
                    <label for=\"numberPlate\">Number Plate</label>
                    <input type=\"text\" name=\"numberPlate\" id=\"numberPlate\" value=\"";
        // line 9
        echo twig_escape_filter($this->env, ($context["numberPlate"] ?? null), "html", null, true);
        echo "\">
                    ";
        // line 10
        if (twig_get_attribute($this->env, $this->source, ($context["errors"] ?? null), "numberPlate", [], "any", false, false, false, 10)) {
            // line 11
            echo "                        <p class=\"errorMsg\">";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["errors"] ?? null), "numberPlate", [], "any", false, false, false, 11), "html", null, true);
            echo "</p>
                    ";
        }
        // line 13
        echo "                    <label for=\"birthDate\">Birth Date</label>
                    <input type=\"date\" name=\"birthDate\" id=\"birthDate\" value=\"";
        // line 14
        echo twig_escape_filter($this->env, ($context["birthDate"] ?? null), "html", null, true);
        echo "\">
                    ";
        // line 15
        if (twig_get_attribute($this->env, $this->source, ($context["errors"] ?? null), "birthDate", [], "any", false, false, false, 15)) {
            // line 16
            echo "                        <p class=\"errorMsg\">";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["errors"] ?? null), "birthDate", [], "any", false, false, false, 16), "html", null, true);
            echo "</p>
                    ";
        }
        // line 18
        echo "                    <label for=\"gender\">Gender</label>
                    <select name=\"gender\" id=\"gender\">
                        ";
        // line 20
        if ((twig_length_filter($this->env, ($context["genders"] ?? null)) < 0)) {
            // line 21
            echo "                            <option value=\"wrong\">something went wrong</option>
                        ";
        }
        // line 23
        echo "                        ";
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["genders"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["value"]) {
            // line 24
            echo "                            <option value=\"";
            echo twig_escape_filter($this->env, $context["value"], "html", null, true);
            echo "\"  ";
            if (($context["value"] == ($context["gender"] ?? null))) {
                echo " selected=\"selected\" ";
            }
            echo " >";
            echo twig_escape_filter($this->env, $context["value"], "html", null, true);
            echo "</option>
                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['value'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 26
        echo "                        <!--<option value=\"\">...</option>
                        <option value=\"M\">M</option>
                        <option value=\"F\">F</option>
                        <option value=\"X\">X</option>-->
                    </select>
                    ";
        // line 31
        if (twig_get_attribute($this->env, $this->source, ($context["errors"] ?? null), "gender", [], "any", false, false, false, 31)) {
            // line 32
            echo "                        <p class=\"errorMsg\">";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["errors"] ?? null), "gender", [], "any", false, false, false, 32), "html", null, true);
            echo "</p>
                    ";
        }
        // line 34
        echo "                    <label for=\"profilePic\">
                        Profile Picture
                    </label>
                    <span>
                        <input type=\"file\" name=\"profilePic\" id=\"profilePic\">
                    </span>
                    ";
        // line 40
        if (twig_get_attribute($this->env, $this->source, ($context["errors"] ?? null), "profilePic", [], "any", false, false, false, 40)) {
            // line 41
            echo "                        <p class=\"errorMsg\">";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["errors"] ?? null), "profilePic", [], "any", false, false, false, 41), "html", null, true);
            echo "</p>
                    ";
        }
        // line 43
        echo "                </section>
                <section class=\"secondFormSection hidden\">
                    <label for=\"carBrand\">Car Brand</label>
                    <input type=\"text\" name=\"carBrand\" id=\"carBrand\" value=\"";
        // line 46
        echo twig_escape_filter($this->env, ($context["carBrand"] ?? null), "html", null, true);
        echo "\">
                    ";
        // line 47
        if (twig_get_attribute($this->env, $this->source, ($context["errors"] ?? null), "carBrand", [], "any", false, false, false, 47)) {
            // line 48
            echo "                        <p class=\"errorMsg\">";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["errors"] ?? null), "carBrand", [], "any", false, false, false, 48), "html", null, true);
            echo "</p>
                    ";
        }
        // line 50
        echo "                    <label for=\"carModel\">Car Model</label>
                    <input type=\"text\" name=\"carModel\" id=\"carModel\" value=\"";
        // line 51
        echo twig_escape_filter($this->env, ($context["carModel"] ?? null), "html", null, true);
        echo "\">
                    ";
        // line 52
        if (twig_get_attribute($this->env, $this->source, ($context["errors"] ?? null), "firstModel", [], "any", false, false, false, 52)) {
            // line 53
            echo "                        <p class=\"errorMsg\">";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["errors"] ?? null), "carModel", [], "any", false, false, false, 53), "html", null, true);
            echo "</p>
                    ";
        }
        // line 55
        echo "                    <label for=\"carPassengers\">Passengers</label>
                    <input type=\"number\" name=\"carPassengers\" id=\"carPassengers\" value=\"";
        // line 56
        echo twig_escape_filter($this->env, ($context["carPassengers"] ?? null), "html", null, true);
        echo "\">
                    ";
        // line 57
        if (twig_get_attribute($this->env, $this->source, ($context["errors"] ?? null), "carPassengers", [], "any", false, false, false, 57)) {
            // line 58
            echo "                        <p class=\"errorMsg\">";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["errors"] ?? null), "carPassengers", [], "any", false, false, false, 58), "html", null, true);
            echo "</p>
                    ";
        }
        // line 60
        echo "                    <input type=\"hidden\" name=\"moduleAction\" value=\"becomeDriver\">
                    <button class=\"btn secondFormSection\" type=\"submit\">Register</button>
                </section>
            </div>
        </form>
        <button class=\"btn formToggle\">Next</button>
    </div>
";
    }

    public function getTemplateName()
    {
        return "/pages/becomeDriver.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  193 => 60,  187 => 58,  185 => 57,  181 => 56,  178 => 55,  172 => 53,  170 => 52,  166 => 51,  163 => 50,  157 => 48,  155 => 47,  151 => 46,  146 => 43,  140 => 41,  138 => 40,  130 => 34,  124 => 32,  122 => 31,  115 => 26,  100 => 24,  95 => 23,  91 => 21,  89 => 20,  85 => 18,  79 => 16,  77 => 15,  73 => 14,  70 => 13,  64 => 11,  62 => 10,  58 => 9,  50 => 3,  46 => 2,  35 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "/pages/becomeDriver.twig", "/var/www/resources/templates/pages/becomeDriver.twig");
    }
}
