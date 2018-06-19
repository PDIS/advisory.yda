<?php

/* C:\xampp\htdocs\demo/themes/responsiv-flat/layouts/default.htm */
class __TwigTemplate_2b489df232c813d0bf4b5e703b7c1d45f8d8ff1fba479e08d73053029de39c67 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html>
    <head>
    \t<meta charset=\"UTF-8\">
        <title>";
        // line 5
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["this"]) ? $context["this"] : null), "page", array()), "title", array()), "html", null, true);
        echo "</title>
        <meta name=\"title\" content=\"";
        // line 6
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["this"]) ? $context["this"] : null), "page", array()), "meta_title", array()), "html", null, true);
        echo "\">
        <meta name=\"description\" content=\"";
        // line 7
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["this"]) ? $context["this"] : null), "page", array()), "meta_description", array()), "html", null, true);
        echo "\">
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
        <meta name=\"author\" content=\"OctoberCMS\">
        <meta name=\"generator\" content=\"OctoberCMS\">
       
        ";
        // line 12
        echo $this->env->getExtension('CMS')->assetsFunction('css');
        echo $this->env->getExtension('CMS')->displayBlock('styles');
        // line 13
        echo "        <link href=\"";
        echo $this->env->getExtension('Cms\Twig\Extension')->themeFilter(array(0 => "assets/less/theme.less"));
        // line 15
        echo "\" rel=\"stylesheet\">
        
        <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
\t\t<!--[if lt IE 9]>
\t\t\t<script src=\"";
        // line 19
        echo $this->env->getExtension('Cms\Twig\Extension')->themeFilter(array(0 => "assets/javascript/html5shiv.js", 1 => "assets/javascript/respond.min.js"));
        // line 22
        echo "\"></script>
\t\t<![endif]-->
    </head>
    <body class=\"page-";
        // line 25
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["this"]) ? $context["this"] : null), "page", array()), "id", array()), "html", null, true);
        echo " layout-";
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["this"]) ? $context["this"] : null), "layout", array()), "id", array()), "html", null, true);
        echo "\">

        <!-- Header -->
        <header id=\"layout-header\" class=\"header-navbar\">
            <!-- Nav -->
            ";
        // line 30
        $context['__cms_partial_params'] = [];
        echo $this->env->getExtension('CMS')->partialFunction("advisory_nav"        , $context['__cms_partial_params']        );
        unset($context['__cms_partial_params']);
        // line 31
        echo "        </header>

        <!-- Content -->
        <div id=\"layout-content\">
            ";
        // line 35
        echo $this->env->getExtension('CMS')->pageFunction();
        // line 36
        echo "        </div>

        <!-- Mailing List -->
        <!--<section id=\"layout-subscribe\" class=\"subscribe-form\">
            ";
        // line 40
        $context['__cms_partial_params'] = [];
        echo $this->env->getExtension('CMS')->partialFunction("subscribe"        , $context['__cms_partial_params']        );
        unset($context['__cms_partial_params']);
        // line 41
        echo "        </section>-->

        <!-- Footer -->
        <footer id=\"layout-footer\">
            ";
        // line 45
        $context['__cms_partial_params'] = [];
        echo $this->env->getExtension('CMS')->partialFunction("advisory_footer"        , $context['__cms_partial_params']        );
        unset($context['__cms_partial_params']);
        // line 46
        echo "        </footer>

        <!-- Scripts -->
        <script src=\"";
        // line 49
        echo $this->env->getExtension('Cms\Twig\Extension')->themeFilter(array(0 => "assets/javascript/jquery.min.js", 1 => "assets/vendor/bootstrap/js/transition.js", 2 => "assets/vendor/bootstrap/js/alert.js", 3 => "assets/vendor/bootstrap/js/button.js", 4 => "assets/vendor/bootstrap/js/carousel.js", 5 => "assets/vendor/bootstrap/js/collapse.js", 6 => "assets/vendor/bootstrap/js/dropdown.js", 7 => "assets/vendor/bootstrap/js/modal.js", 8 => "assets/vendor/bootstrap/js/tooltip.js", 9 => "assets/vendor/bootstrap/js/popover.js", 10 => "assets/vendor/bootstrap/js/scrollspy.js", 11 => "assets/vendor/bootstrap/js/tab.js", 12 => "assets/vendor/bootstrap/js/affix.js", 13 => "assets/vendor/jquery-ui/js/jquery.ui.core.js", 14 => "assets/vendor/jquery-ui/js/jquery.ui.widget.js", 15 => "assets/vendor/jquery-ui/js/jquery.ui.mouse.js", 16 => "assets/vendor/jquery-ui/js/jquery.ui.position.js", 17 => "assets/vendor/jquery-ui/js/jquery.ui.button.js", 18 => "assets/vendor/jquery-ui/js/jquery.ui.slider.js", 19 => "assets/vendor/jquery-ui/js/jquery.ui.effects.js", 20 => "assets/vendor/jquery-ui/js/jquery.ui.touchpunch.js", 21 => "assets/vendor/flat-ui/js/video.js", 22 => "assets/vendor/flat-ui/js/bootstrap-switch.js", 23 => "assets/vendor/flat-ui/js/bootstrap-tagsinput.js", 24 => "assets/vendor/flat-ui/js/holder.js", 25 => "assets/vendor/flat-ui/js/typeahead.jquery.js", 26 => "assets/vendor/flat-ui/js/select2.js", 27 => "assets/vendor/flat-ui/js/flatui-radiocheck.js", 28 => "assets/javascript/app.js"));
        // line 83
        echo "\"></script>
        <script>
        \tvideojs.options.flash.swf = \"";
        // line 85
        echo $this->env->getExtension('Cms\Twig\Extension')->themeFilter("assets/vendor/flat-ui/js/video-js.swf");
        echo "\";
        </script>
        ";
        // line 87
        echo '<script src="'. Request::getBasePath()
                .'/modules/system/assets/js/framework.js"></script>'.PHP_EOL;
        echo '<script src="'. Request::getBasePath()
                    .'/modules/system/assets/js/framework.extras.js"></script>'.PHP_EOL;
        echo '<link rel="stylesheet" property="stylesheet" href="'. Request::getBasePath()
                    .'/modules/system/assets/css/framework.extras.css">'.PHP_EOL;
        // line 88
        echo "        ";
        echo $this->env->getExtension('CMS')->assetsFunction('js');
        echo $this->env->getExtension('CMS')->displayBlock('scripts');
        // line 89
        echo "
    </body>
</html>";
    }

    public function getTemplateName()
    {
        return "C:\\xampp\\htdocs\\demo/themes/responsiv-flat/layouts/default.htm";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  129 => 89,  125 => 88,  118 => 87,  113 => 85,  109 => 83,  107 => 49,  102 => 46,  98 => 45,  92 => 41,  88 => 40,  82 => 36,  80 => 35,  74 => 31,  70 => 30,  60 => 25,  55 => 22,  53 => 19,  47 => 15,  44 => 13,  41 => 12,  33 => 7,  29 => 6,  25 => 5,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("<!DOCTYPE html>
<html>
    <head>
    \t<meta charset=\"UTF-8\">
        <title>{{ this.page.title }}</title>
        <meta name=\"title\" content=\"{{ this.page.meta_title }}\">
        <meta name=\"description\" content=\"{{ this.page.meta_description }}\">
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
        <meta name=\"author\" content=\"OctoberCMS\">
        <meta name=\"generator\" content=\"OctoberCMS\">
       
        {% styles %}
        <link href=\"{{ [
            'assets/less/theme.less'
        ]|theme }}\" rel=\"stylesheet\">
        
        <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
\t\t<!--[if lt IE 9]>
\t\t\t<script src=\"{{ [
\t\t\t\t'assets/javascript/html5shiv.js',
\t\t\t\t'assets/javascript/respond.min.js',
\t\t\t]|theme }}\"></script>
\t\t<![endif]-->
    </head>
    <body class=\"page-{{ this.page.id }} layout-{{ this.layout.id }}\">

        <!-- Header -->
        <header id=\"layout-header\" class=\"header-navbar\">
            <!-- Nav -->
            {% partial \"advisory_nav\" %}
        </header>

        <!-- Content -->
        <div id=\"layout-content\">
            {% page %}
        </div>

        <!-- Mailing List -->
        <!--<section id=\"layout-subscribe\" class=\"subscribe-form\">
            {% partial \"subscribe\" %}
        </section>-->

        <!-- Footer -->
        <footer id=\"layout-footer\">
            {% partial \"advisory_footer\" %}
        </footer>

        <!-- Scripts -->
        <script src=\"{{ [
            'assets/javascript/jquery.min.js',
            
            'assets/vendor/bootstrap/js/transition.js',
            'assets/vendor/bootstrap/js/alert.js',
            'assets/vendor/bootstrap/js/button.js',
            'assets/vendor/bootstrap/js/carousel.js',
            'assets/vendor/bootstrap/js/collapse.js',
            'assets/vendor/bootstrap/js/dropdown.js',
            'assets/vendor/bootstrap/js/modal.js',
            'assets/vendor/bootstrap/js/tooltip.js',
            'assets/vendor/bootstrap/js/popover.js',
            'assets/vendor/bootstrap/js/scrollspy.js',
            'assets/vendor/bootstrap/js/tab.js',
            'assets/vendor/bootstrap/js/affix.js',

            'assets/vendor/jquery-ui/js/jquery.ui.core.js',
            'assets/vendor/jquery-ui/js/jquery.ui.widget.js',
            'assets/vendor/jquery-ui/js/jquery.ui.mouse.js',
            'assets/vendor/jquery-ui/js/jquery.ui.position.js',
            'assets/vendor/jquery-ui/js/jquery.ui.button.js',
            'assets/vendor/jquery-ui/js/jquery.ui.slider.js',
            'assets/vendor/jquery-ui/js/jquery.ui.effects.js',
            'assets/vendor/jquery-ui/js/jquery.ui.touchpunch.js',
            
            'assets/vendor/flat-ui/js/video.js',
            'assets/vendor/flat-ui/js/bootstrap-switch.js',
            'assets/vendor/flat-ui/js/bootstrap-tagsinput.js',
            'assets/vendor/flat-ui/js/holder.js',
            'assets/vendor/flat-ui/js/typeahead.jquery.js',
            'assets/vendor/flat-ui/js/select2.js',
            'assets/vendor/flat-ui/js/flatui-radiocheck.js',
            
            'assets/javascript/app.js'
        ]|theme }}\"></script>
        <script>
        \tvideojs.options.flash.swf = \"{{ 'assets/vendor/flat-ui/js/video-js.swf'|theme }}\";
        </script>
        {% framework extras %}
        {% scripts %}

    </body>
</html>", "C:\\xampp\\htdocs\\demo/themes/responsiv-flat/layouts/default.htm", "");
    }
}
