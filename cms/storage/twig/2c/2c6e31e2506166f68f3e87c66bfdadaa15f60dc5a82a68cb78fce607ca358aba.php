<?php

/* C:\xampp\htdocs\demo/themes/responsiv-flat/partials/subscribe.htm */
class __TwigTemplate_953e3af2a39ea68c7f08d13fb68eaea4e1cdb0b9c4e5fa0f74a70b266ce16673 extends Twig_Template
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
        echo "<div class=\"container\">
    <div class=\"row\">
        <form>
            <div class=\"col-sm-8\">
                <input type=\"text\" placeholder=\"Enter your e-mail\" spellcheck=\"false\">
            </div>
            <div class=\"col-sm-4\">
                <button class=\"btn btn-lg btn-primary\" type=\"submit\">
                    Join newsletter
                </button>
            </div>
        </form>
    </div>
</div>";
    }

    public function getTemplateName()
    {
        return "C:\\xampp\\htdocs\\demo/themes/responsiv-flat/partials/subscribe.htm";
    }

    public function getDebugInfo()
    {
        return array (  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("<div class=\"container\">
    <div class=\"row\">
        <form>
            <div class=\"col-sm-8\">
                <input type=\"text\" placeholder=\"Enter your e-mail\" spellcheck=\"false\">
            </div>
            <div class=\"col-sm-4\">
                <button class=\"btn btn-lg btn-primary\" type=\"submit\">
                    Join newsletter
                </button>
            </div>
        </form>
    </div>
</div>", "C:\\xampp\\htdocs\\demo/themes/responsiv-flat/partials/subscribe.htm", "");
    }
}
