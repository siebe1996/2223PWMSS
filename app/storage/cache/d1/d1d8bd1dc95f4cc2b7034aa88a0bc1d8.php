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

/* /partials/common.twig */
class __TwigTemplate_494b389c5a66f3c6bf178cfa6f1cfcff extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
            'main' => [$this, 'block_main'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo "<!DOCTYPE html>
<html lang=\"en\">
<head>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\"
          content=\"width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0\">
    <meta http-equiv=\"X-UA-Compatible\" content=\"ie=edge\">
    <link rel=\"stylesheet\" href=\"../styles.css\">
    <script src=\"../navbar.js\" defer></script>
    <title>Document</title>
</head>
<body>
<header>
    <a href=\"./index.php\">
        <h1>Rebu</h1>
    </a>
    <button class=\"navbarToggle\">
        Menu
        <svg width=\"27\" height=\"27\" viewBox=\"0 0 27 27\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\">
            <path
                    d=\"M23.625 20.25H3.375V18H23.625V20.25ZM23.625 14.625H3.375V12.375H23.625V14.625ZM23.625 9H3.375V6.75H23.625V9Z\"
                    fill=\"white\" />
        </svg>

    </button>

    <nav>
        <h2>Menu</h2>
        <button class=\"navbarToggle\">
            <svg width=\"20\" height=\"20\" viewBox=\"0 0 27 27\" fill=\"none\"
                 xmlns=\"http://www.w3.org/2000/svg\">
                <g clip-path=\"url(#clip0_8_70)\">
                    <path d=\"M1.6875 25.3125L25.3125 1.6875M25.3125 25.3125L1.6875 1.6875\" stroke=\"white\"
                          stroke-width=\"1.6875\" stroke-linecap=\"round\" stroke-linejoin=\"round\" />
                </g>
            </svg>
        </button>

        <ul>
            <li>
                <a href=\"./login.php\">
                    <svg width=\"27\" height=\"27\" viewBox=\"0 0 27 27\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\">
                        <g clip-path=\"url(#clip0_7_44)\">
                            <path
                                    d=\"M27 13.4865C27 6.04125 20.952 0 13.5 0C6.048 0 0 6.04125 0 13.4865C0 17.5871 1.863 21.2827 4.779 23.7634C4.806 23.7904 4.833 23.7904 4.833 23.8174C5.076 24.0064 5.319 24.1954 5.589 24.3844C5.724 24.4654 5.832 24.5717 5.967 24.6797C8.19799 26.1923 10.8316 27.0006 13.527 27C16.2224 27.0006 18.856 26.1923 21.087 24.6797C21.222 24.5987 21.33 24.4924 21.465 24.4097C21.708 24.2224 21.978 24.0334 22.221 23.8444C22.248 23.8174 22.275 23.8174 22.275 23.7904C25.137 21.2811 27 17.5871 27 13.4865ZM13.5 25.3007C10.962 25.3007 8.64 24.4907 6.723 23.1424C6.75 22.9264 6.804 22.7121 6.858 22.4961C7.01888 21.9107 7.25484 21.3486 7.56 20.8237C7.857 20.3108 8.208 19.8517 8.64 19.4468C9.045 19.0417 9.531 18.6654 10.017 18.3684C10.53 18.0714 11.07 17.8554 11.664 17.6934C12.2626 17.5321 12.88 17.4509 13.5 17.4521C15.3405 17.4391 17.1133 18.1451 18.441 19.4198C19.062 20.0408 19.548 20.7698 19.899 21.6051C20.088 22.0911 20.223 22.6041 20.304 23.1424C18.3114 24.5433 15.9358 25.2968 13.5 25.3007ZM9.369 12.8132C9.1311 12.2685 9.01147 11.6795 9.018 11.0852C9.018 10.4929 9.126 9.89888 9.369 9.35888C9.612 8.81888 9.936 8.33456 10.341 7.92956C10.746 7.52456 11.232 7.20225 11.772 6.95925C12.312 6.71625 12.906 6.60825 13.5 6.60825C14.121 6.60825 14.688 6.71625 15.228 6.95925C15.768 7.20225 16.254 7.52625 16.659 7.92956C17.064 8.33456 17.388 8.82056 17.631 9.35888C17.874 9.89888 17.982 10.4929 17.982 11.0852C17.982 11.7062 17.874 12.2732 17.631 12.8115C17.3965 13.3435 17.0671 13.8284 16.659 14.2425C16.2448 14.65 15.7599 14.9788 15.228 15.2128C14.1123 15.6713 12.8607 15.6713 11.745 15.2128C11.2131 14.9788 10.7282 14.65 10.314 14.2425C9.90531 13.8344 9.58381 13.3476 9.369 12.8115V12.8132ZM21.897 21.7671C21.897 21.7131 21.87 21.6861 21.87 21.6321C21.6045 20.7873 21.2131 19.9875 20.709 19.2594C20.2045 18.526 19.5844 17.8792 18.873 17.3441C18.3297 16.9354 17.7407 16.5911 17.118 16.3181C17.4013 16.1312 17.6638 15.9146 17.901 15.6718C18.3035 15.2744 18.6571 14.8303 18.954 14.3488C19.552 13.3664 19.8608 12.2352 19.845 11.0852C19.8534 10.2339 19.688 9.38979 19.359 8.60456C19.0342 7.84795 18.5667 7.161 17.982 6.58125C17.3982 6.00755 16.7111 5.5495 15.957 5.23125C15.1705 4.90285 14.3253 4.73807 13.473 4.74694C12.6206 4.7386 11.7754 4.90396 10.989 5.23294C10.2284 5.5505 9.53962 6.01827 8.964 6.60825C8.39032 7.19143 7.93225 7.87796 7.614 8.63156C7.28502 9.41679 7.11965 10.2609 7.128 11.1122C7.128 11.7062 7.209 12.2732 7.371 12.8115C7.533 13.3785 7.749 13.8915 8.046 14.3758C8.316 14.8618 8.694 15.2938 9.099 15.6988C9.342 15.9418 9.612 16.1561 9.909 16.3451C9.28435 16.6254 8.69521 16.9788 8.154 17.3981C7.452 17.9381 6.831 18.5844 6.318 19.2864C5.80881 20.0114 5.41701 20.8121 5.157 21.6591C5.13 21.7131 5.13 21.7671 5.13 21.7941C2.997 19.6357 1.674 16.7231 1.674 13.4865C1.674 6.98625 6.993 1.67231 13.5 1.67231C20.007 1.67231 25.326 6.98625 25.326 13.4865C25.3225 16.5914 24.0896 19.5686 21.897 21.7671Z\"
                                    fill=\"white\" />
                        </g>
                    </svg>
                    Log in / Register
                </a>
            </li>
            <li><a href=\"./becomeDriver.php\">Become a driver</a></li>
            <li><a href=\"#\">Trip history</a></li>
            <li><a href=\"#\">Reviews</a></li>
            <li>
                <form class=\"navbar-form navbar-right\" method=\"post\" action=\"logout.php\">
                    <button type=\"submit\" class=\"btn btn-default\">Uitloggen</button>
                </form>
            </li>
        </ul>
    </nav>
</header>
<main>
    ";
        // line 64
        $this->displayBlock('main', $context, $blocks);
        // line 66
        echo "</main>
<footer>
    Siebe, Bert en Lukas
</footer>
</body>
</html>
";
    }

    // line 64
    public function block_main($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 65
        echo "    ";
    }

    public function getTemplateName()
    {
        return "/partials/common.twig";
    }

    public function getDebugInfo()
    {
        return array (  119 => 65,  115 => 64,  105 => 66,  103 => 64,  38 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "/partials/common.twig", "/var/www/resources/templates/partials/common.twig");
    }
}
