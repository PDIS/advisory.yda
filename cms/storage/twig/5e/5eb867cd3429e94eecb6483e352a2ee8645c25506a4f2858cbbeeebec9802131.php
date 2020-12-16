<?php

/* C:\xampp\htdocs\demo/themes/responsiv-flat/partials/advisory_nav.htm */
class __TwigTemplate_29cce653664d3b3dd6e35ddee19d28ab4740af58d114fbd6cfd1254d63cedc0a extends Twig_Template
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
        // line 2
        $context["links"] = array("proposal" => array(0 => "proposal", 1 => "提案"), "track" => array(0 => "blog/blog", 1 => "Track"));
        // line 8
        echo "
";
        // line 29
        echo "
";
        // line 30
        $context["nav"] = $this;
        // line 31
        echo "
<nav id=\"layout-nav\" class=\"navbar navbar-inverse navbar-fixed-top\" role=\"navigation\">
    <div class=\"container\">
        <div class=\"navbar-header\">
            <button type=\"button\"  class=\"navbar-toggle\"  data-toggle=\"collapse\" data-target=\".navbar-main-collapse\">
                <span class=\"sr-only\">Toggle navigation</span>
             <!--<span class=\"fa fa-bars\"></span>-->
            </button>
            <a class=\"navbar-brand\" href=\"";
        // line 39
        echo $this->env->getExtension('Cms\Twig\Extension')->pageFilter("advisory_home");
        echo "\">青諮</a>
        </div>
        <div class=\"collapse navbar-collapse navbar-main-collapse\">
            <ul class=\"nav navbar-nav navbar-right\">
                ";
        // line 43
        echo $context["nav"]->getrender_menu((isset($context["links"]) ? $context["links"] : null));
        echo "
                <li>
                    <button
                        onclick=\"window.location='";
        // line 46
        echo $this->env->getExtension('Cms\Twig\Extension')->pageFilter("sign/sign-test");
        echo "'\"
                        class=\"btn btn-sm navbar-btn btn-primary navbar-right hidden-sm hidden-xs\">
                        Sign in
                    </button>
                </li>
            </ul>
        </div>
    </div>
</nav>";
    }

    // line 9
    public function getrender_menu($__links__ = null, ...$__varargs__)
    {
        $context = $this->env->mergeGlobals(array(
            "links" => $__links__,
            "varargs" => $__varargs__,
        ));

        $blocks = array();

        ob_start();
        try {
            // line 10
            echo "    ";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["links"]) ? $context["links"] : null));
            foreach ($context['_seq'] as $context["code"] => $context["link"]) {
                // line 11
                echo "        <li class=\"";
                echo ((($context["code"] == (isset($context["currentPage"]) ? $context["currentPage"] : null))) ? ("active") : (""));
                echo " ";
                echo (($this->getAttribute($context["link"], "sublinks", array())) ? ("dropdown") : (""));
                echo "\">
            <a
                href=\"";
                // line 13
                echo (($this->getAttribute($context["link"], "sublinks", array())) ? ("#") : ($this->env->getExtension('Cms\Twig\Extension')->pageFilter((($this->getAttribute($context["link"], "page", array())) ? ($this->getAttribute($context["link"], "page", array())) : ($this->getAttribute($context["link"], 0, array(), "array"))))));
                echo "\"
                ";
                // line 14
                if ($this->getAttribute($context["link"], "sublinks", array())) {
                    echo "data-toggle=\"dropdown\"";
                }
                // line 15
                echo "                class=\"";
                echo (($this->getAttribute($context["link"], "sublinks", array())) ? ("dropdown-toggle") : (""));
                echo "\"
            >
                ";
                // line 17
                echo twig_escape_filter($this->env, (($this->getAttribute($context["link"], "name", array())) ? ($this->getAttribute($context["link"], "name", array())) : ($this->getAttribute($context["link"], 1, array(), "array"))), "html", null, true);
                echo "
                ";
                // line 18
                if ($this->getAttribute($context["link"], "sublinks", array())) {
                    echo "<span class=\"caret\"></span>";
                }
                // line 19
                echo "            </a>
            ";
                // line 20
                if ($this->getAttribute($context["link"], "sublinks", array())) {
                    // line 21
                    echo "                <span class=\"dropdown-arrow\"></span>
                <ul class=\"dropdown-menu\">
                    ";
                    // line 23
                    echo $this->getAttribute($this, "render_menu", array(0 => $this->getAttribute($context["link"], "sublinks", array())), "method");
                    echo "
                </ul>
            ";
                }
                // line 26
                echo "        </li>
    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['code'], $context['link'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
        } catch (Exception $e) {
            ob_end_clean();

            throw $e;
        } catch (Throwable $e) {
            ob_end_clean();

            throw $e;
        }

        return ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
    }

    public function getTemplateName()
    {
        return "C:\\xampp\\htdocs\\demo/themes/responsiv-flat/partials/advisory_nav.htm";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  127 => 26,  121 => 23,  117 => 21,  115 => 20,  112 => 19,  108 => 18,  104 => 17,  98 => 15,  94 => 14,  90 => 13,  82 => 11,  77 => 10,  65 => 9,  52 => 46,  46 => 43,  39 => 39,  29 => 31,  27 => 30,  24 => 29,  21 => 8,  19 => 2,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("{# Note: Only one levels of sublinks are supported by Bootstrap 3 #}
{% set
    links = {
        'proposal': ['proposal', '提案'],
        'track': ['blog/blog', 'Track']
    }
%}

{% macro render_menu(links) %}
    {% for code, link in links %}
        <li class=\"{{ code == currentPage ? 'active' }} {{ link.sublinks ? 'dropdown' }}\">
            <a
                href=\"{{ link.sublinks ? '#' : (link.page ?: link[0])|page }}\"
                {% if link.sublinks %}data-toggle=\"dropdown\"{% endif %}
                class=\"{{ link.sublinks ? 'dropdown-toggle' }}\"
            >
                {{ link.name ?: link[1] }}
                {% if link.sublinks %}<span class=\"caret\"></span>{% endif %}
            </a>
            {% if link.sublinks %}
                <span class=\"dropdown-arrow\"></span>
                <ul class=\"dropdown-menu\">
                    {{ _self.render_menu(link.sublinks) }}
                </ul>
            {% endif %}
        </li>
    {% endfor %}
{% endmacro %}

{% import _self as nav %}

<nav id=\"layout-nav\" class=\"navbar navbar-inverse navbar-fixed-top\" role=\"navigation\">
    <div class=\"container\">
        <div class=\"navbar-header\">
            <button type=\"button\"  class=\"navbar-toggle\"  data-toggle=\"collapse\" data-target=\".navbar-main-collapse\">
                <span class=\"sr-only\">Toggle navigation</span>
             <!--<span class=\"fa fa-bars\"></span>-->
            </button>
            <a class=\"navbar-brand\" href=\"{{ 'advisory_home'|page }}\">青諮</a>
        </div>
        <div class=\"collapse navbar-collapse navbar-main-collapse\">
            <ul class=\"nav navbar-nav navbar-right\">
                {{ nav.render_menu(links) }}
                <li>
                    <button
                        onclick=\"window.location='{{ 'sign/sign-test'|page }}'\"
                        class=\"btn btn-sm navbar-btn btn-primary navbar-right hidden-sm hidden-xs\">
                        Sign in
                    </button>
                </li>
            </ul>
        </div>
    </div>
</nav>", "C:\\xampp\\htdocs\\demo/themes/responsiv-flat/partials/advisory_nav.htm", "");
    }
}
