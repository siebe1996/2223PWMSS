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

/* /pages/home.twig */
class __TwigTemplate_b9e90890dacf996526f310d70f96d056 extends Template
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
        $this->parent = $this->loadTemplate("/partials/common.twig", "/pages/home.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_main($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 3
        echo "<div id=\"map\"></div>
<div class=\"panel bottom\">
    <form action=\"\" method=\"POST\" enctype=\"application/x-www-form-urlencoded\">
        <div class=\"form\" id=\"homeForm\">
            <label for=\"startLocation\">From:</label>
            <input type=\"text\" id=\"startLocation\" name=\"startLocation\">
            <label for=\"endLocation\">To:</label>
            <input type=\"text\" name=\"endLocation\" id=\"endLocation\">
            <label for=\"time\">When:</label>
            <input type=\"time\" name=\"time\" id=\"time\">
            <button class=\"btn\" type=\"submit\">Request Ride</button>
        </div>
    </form>
    <button class=\"closeHomeOverlay\">
        <svg width=\"20\" height=\"20\" viewBox=\"0 0 27 27\" fill=\"none\"
             xmlns=\"http://www.w3.org/2000/svg\">
            <g clip-path=\"url(#clip0_8_70)\">
                <path d=\"M1.6875 25.3125L25.3125 1.6875M25.3125 25.3125L1.6875 1.6875\" stroke=\"currentColor\"
                      stroke-width=\"1.6875\" stroke-linecap=\"round\" stroke-linejoin=\"round\"/>
            </g>
        </svg>
    </button>
</div>
<button class=\"btn newRideToggle\">
    <svg width=\"25\" height=\"25\" viewBox=\"0 0 27 27\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\">
        <path
                d=\"M24.7978 13.5675L19.1531 11.1459L17.01 7.48406L16.9425 7.38281C16.7845 7.18547 16.5842 7.02616 16.3564 6.91663C16.1286 6.8071 15.879 6.75015 15.6263 6.74999H8.87625C8.59764 6.74912 8.32316 6.81723 8.07729 6.94827C7.83142 7.0793 7.62181 7.26917 7.46719 7.50093L4.60688 11.8125H2.53125C2.30747 11.8125 2.09286 11.9014 1.93463 12.0596C1.77639 12.2179 1.6875 12.4325 1.6875 12.6562V20.25C1.6875 20.4738 1.77639 20.6884 1.93463 20.8466C2.09286 21.0048 2.30747 21.0937 2.53125 21.0937H4.33687C4.53118 21.8087 4.95535 22.4399 5.54394 22.8899C6.13254 23.3398 6.85285 23.5836 7.59375 23.5836C8.33465 23.5836 9.05496 23.3398 9.64356 22.8899C10.2322 22.4399 10.6563 21.8087 10.8506 21.0937H16.1494C16.3437 21.8087 16.7678 22.4399 17.3564 22.8899C17.945 23.3398 18.6654 23.5836 19.4062 23.5836C20.1471 23.5836 20.8675 23.3398 21.4561 22.8899C22.0447 22.4399 22.4688 21.8087 22.6631 21.0937H24.4688C24.6925 21.0937 24.9071 21.0048 25.0654 20.8466C25.2236 20.6884 25.3125 20.4738 25.3125 20.25V14.3437C25.3124 14.1781 25.2635 14.0162 25.172 13.8782C25.0804 13.7401 24.9503 13.6321 24.7978 13.5675ZM7.59375 21.9375C7.25999 21.9375 6.93373 21.8385 6.65623 21.6531C6.37872 21.4677 6.16243 21.2041 6.0347 20.8958C5.90698 20.5874 5.87356 20.2481 5.93867 19.9208C6.00379 19.5934 6.16451 19.2928 6.40051 19.0568C6.63651 18.8207 6.93719 18.66 7.26454 18.5949C7.59188 18.5298 7.93118 18.5632 8.23953 18.6909C8.54788 18.8187 8.81143 19.035 8.99685 19.3125C9.18228 19.59 9.28125 19.9162 9.28125 20.25C9.28125 20.6975 9.10346 21.1268 8.78699 21.4432C8.47052 21.7597 8.0413 21.9375 7.59375 21.9375ZM19.4062 21.9375C19.0725 21.9375 18.7462 21.8385 18.4687 21.6531C18.1912 21.4677 17.9749 21.2041 17.8472 20.8958C17.7195 20.5874 17.6861 20.2481 17.7512 19.9208C17.8163 19.5934 17.977 19.2928 18.213 19.0568C18.449 18.8207 18.7497 18.66 19.077 18.5949C19.4044 18.5298 19.7437 18.5632 20.052 18.6909C20.3604 18.8187 20.6239 19.035 20.8094 19.3125C20.9948 19.59 21.0938 19.9162 21.0938 20.25C21.0938 20.6975 20.916 21.1268 20.5995 21.4432C20.283 21.7597 19.8538 21.9375 19.4062 21.9375ZM23.625 19.4062H22.6631C22.4688 18.6913 22.0447 18.0601 21.4561 17.6101C20.8675 17.1601 20.1471 16.9163 19.4062 16.9163C18.6654 16.9163 17.945 17.1601 17.3564 17.6101C16.7678 18.0601 16.3437 18.6913 16.1494 19.4062H10.8506C10.6563 18.6913 10.2322 18.0601 9.64356 17.6101C9.05496 17.1601 8.33465 16.9163 7.59375 16.9163C6.85285 16.9163 6.13254 17.1601 5.54394 17.6101C4.95535 18.0601 4.53118 18.6913 4.33687 19.4062H3.375V13.5H5.0625C5.20147 13.4993 5.33811 13.4642 5.46029 13.398C5.58246 13.3318 5.68638 13.2364 5.76281 13.1203L8.89312 8.43749H15.6431L17.8622 12.2344C17.9527 12.3922 18.0918 12.5165 18.2587 12.5887L23.625 14.9006V19.4062Z\"
                fill=\"white\" />
    </svg>
    New Ride
</button>
";
    }

    public function getTemplateName()
    {
        return "/pages/home.twig";
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
        return new Source("", "/pages/home.twig", "/var/www/resources/templates/pages/home.twig");
    }
}
