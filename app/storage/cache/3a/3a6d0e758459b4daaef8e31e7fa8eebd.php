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
        <form action=\".php\" method=\"post\" novalidate>
            <div class=\"form\" id=\"registerDriver\">
                <section class=\"firstFormSection\">
                    <label for=\"numberPlate\">Number Plate</label>
                    <input type=\"text\" name=\"numberPlate\" id=\"numberPlate\">
                    <label for=\"birthDate\">Birth Date</label>
                    <input type=\"date\" name=\"birthDate\" id=\"birthDate\">
                    <label for=\"gender\">Gender</label>
                    <select name=\"gender\" id=\"gender\">
                        <option value=\"\">...</option>
                        <option value=\"M\">M</option>
                        <option value=\"F\">F</option>
                        <option value=\"X\">X</option>
                    </select>
                    <label for=\"profilePic\">
                        Profile Picture
                    </label>
                    <span>
                        <input type=\"file\" name=\"profilePic\" id=\"profilePic\">
                    </span>
                </section>
                <section class=\"secondFormSection\">
                    <label for=\"carBrand\">Car Brand</label>
                    <span>
                    <input type=\"text\" name=\"carBrand\" id=\"carBrand\">
                    </span>
                    <label for=\"carModel\">Car Model</label>
                    <span>
                    <input type=\"text\" name=\"carModel\" id=\"carModel\">
                    </span>
                    <label for=\"carPassengers\">Passengers</label>
                    <span>
                        <input type=\"number\" name=\"carPassenger\" id=\"carPassengers\">
                    </span>
                </section>
                <button class=\"btn firstFormSection\">Next</button>
                <button class=\"btn secondFormSection\" type=\"submit\">Register</button>
            </div>
        </form>
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
        return array (  50 => 3,  46 => 2,  35 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "/pages/becomeDriver.twig", "/var/www/resources/templates/pages/becomeDriver.twig");
    }
}
