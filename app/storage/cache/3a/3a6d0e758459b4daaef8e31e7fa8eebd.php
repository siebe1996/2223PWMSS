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
                    <input type=\"text\" name=\"numberPlate\" id=\"numberPlate\">
                    <label for=\"birthDate\">Birth Date</label>
                    <input type=\"date\" name=\"birthDate\" id=\"birthDate\">
                    <label for=\"gender\">Gender</label>
                    <select name=\"gender\" id=\"gender\">
                        ";
        // line 14
        if ((twig_length_filter($this->env, ($context["genders"] ?? null)) < 0)) {
            // line 15
            echo "                            <option value=\"wrong\">something went wrong</option>
                        ";
        }
        // line 17
        echo "                        ";
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["genders"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["value"]) {
            // line 18
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
        // line 20
        echo "                        <!--<option value=\"\">...</option>
                        <option value=\"M\">M</option>
                        <option value=\"F\">F</option>
                        <option value=\"X\">X</option>-->
                    </select>
                    <label for=\"profilePic\">
                        Profile Picture
                    </label>
                    <span>
                        <input type=\"file\" name=\"profilePic\" id=\"profilePic\">
                    </span>
                </section>
                <section class=\"secondFormSection hidden\">
                    <label for=\"carBrand\">Car Brand</label>
                    <input type=\"text\" name=\"carBrand\" id=\"carBrand\">
                    <label for=\"carModel\">Car Model</label>
                    <input type=\"text\" name=\"carModel\" id=\"carModel\">
                    <label for=\"carPassengers\">Passengers</label>
                    <input type=\"number\" name=\"carPassengers\" id=\"carPassengers\">
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
        return array (  89 => 20,  74 => 18,  69 => 17,  65 => 15,  63 => 14,  50 => 3,  46 => 2,  35 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "/pages/becomeDriver.twig", "/var/www/resources/templates/pages/becomeDriver.twig");
    }
}
