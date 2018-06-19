<?php

/* C:\xampp\htdocs\demo/themes/responsiv-flat/pages/advisory_home.htm */
class __TwigTemplate_9de9dc31b1574fd3d7a6ac8d45b50e1b8bfe34dea85792afaac10389c0351793 extends Twig_Template
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
        echo "<section class=\"home-title\">
    <div class=\"container\">
        <div class=\"row\">
            <div class=\"col-sm-4\">
            
                <a href=\"";
        // line 6
        echo $this->env->getExtension('Cms\Twig\Extension')->pageFilter("users/nikes");
        echo "\"><img src=\"";
        echo $this->env->getExtension('Cms\Twig\Extension')->themeFilter("assets/images/users/advisor_1.png");
        echo "\"  style=\"width:100%; height: 100%\"></a>
                <p>黃敬峰，從高中開始就被人叫做阿峰，在工作兩年後，被Accupass創辦人與AVEDA台灣代理商負責人說服出來創業，與高中同學林宏諺兩人共同創辦了「共同創辦了「交點」，透過分享的方式，讓更多台灣的年輕人有舞台可以發揮，有麥克風可以分享出屬於自己的故事。從2012年5月至今，已經舉辦超過300場大大小小的聚會活動，透過交點，聽到了全台灣超過6000個故事，600個動人分享！</p>
                
                <!--<div class=\"signup-form\">
                    <form>
                        <div class=\"form-group\">
                            <input class=\"form-control\" type=\"text\" placeholder=\"Your E-mail\">
                        </div>
                        <div class=\"form-group\">
                            <div>
                                <input type=\"password\" class=\"form-control\" placeholder=\"Password\">
                            </div>
                            <div>
                                <input type=\"password\" class=\"form-control\" placeholder=\"Confirmation\">
                            </div>
                        </div>
                        <div class=\"form-group\">
                            <button type=\"submit\" class=\"btn btn-block btn-info\">Sign Up</button>
                        </div>
                    </form>
                </div>
                <div class=\"additional-links\">
                    By signing up you agree to <a href=\"#\">Terms of Use</a> and <a href=\"#\">Privacy Policy</a>
                </div>-->
            </div>
            <!--<div class=\"col-sm-7 col-sm-offset-1 player-wrapper\">
                <div class=\"player\">
                    <iframe src=\"http://player.vimeo.com/video/29568236?color=3498db\" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                </div>                
            </div>-->
            <div id=\"portfolioItems\" class=\"row\">
              
              
           ";
        // line 39
        $context['__cms_partial_params'] = [];
        echo $this->env->getExtension('CMS')->partialFunction("user"        , $context['__cms_partial_params']        );
        unset($context['__cms_partial_params']);
        // line 40
        echo "                
               
               
        
            </div>
              ";
        // line 45
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["blogTags"]) ? $context["blogTags"] : null), "tags", array()));
        foreach ($context['_seq'] as $context["_key"] => $context["tag"]) {
            // line 46
            echo " ";
            $context["tag_size"] = twig_length_filter($this->env, $this->getAttribute($context["tag"], "posts", array()));
            // line 47
            echo "        <div class=\"col-md-2 portfolio-item nature people\">
            <div class=\"picture\">
                <div class=\"description\">
                    <a href=\"/tags/";
            // line 50
            echo twig_escape_filter($this->env, $this->getAttribute($context["tag"], "name", array()), "html", null, true);
            echo "\" class=\"btn btn-info btn-block\">";
            echo twig_escape_filter($this->env, $this->getAttribute($context["tag"], "name", array()), "html", null, true);
            echo "</a>
                </div>
            </div>
        </div>
        
   ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['tag'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 56
        echo "        </div> 
    </div>
</section>


<br />

<div class=\"container\">

    <!-- Services -->
    <div class=\"row our-services\">
        <div class=\"col-sm-12\">
            <h4 class=\"headline\"><span>我們關心的領域</span></h4>
            <!--<p>He hasn't got a freckle my mad as a middy. Trent from punchy maccas no dramas shazza got us some ripper. As dry as a bradman flamin lets throw a cut lunch commando.</p>-->
                  <div id=\"cloudtag\"></div>
            
        </div>
    </div>

    <div class=\"recent-tweets\">
        <h4 class=\"headline\"><span>認識青諮會</span></h4>
 <div class=\"container\">
\t<div class=\"row\">
\t    <div class=\" col-sm-6 col-md-4 card\">
    \t\t<a href=\"";
        // line 80
        echo $this->env->getExtension('Cms\Twig\Extension')->pageFilter("yda_open");
        echo "\">
    \t\t<div class=\"thumbnail\">
    \t
    \t\t\t<div class=\"caption\" style=\"text-align:center;\">
    \t\t\t\t<h3>
                        青諮會緣起
    \t\t\t\t</h3>
    \t\t\t
    \t\t\t</div>
    \t\t</div>
    \t\t</a>
    \t</div>
     <div class=\" col-sm-6 col-md-4 card\">
    \t\t<a href=\"";
        // line 93
        echo $this->env->getExtension('Cms\Twig\Extension')->pageFilter("yda_points");
        echo "\">
    \t\t<div class=\"thumbnail\">
    \t
    \t\t\t<div class=\"caption\" style=\"text-align:center;\">
    \t\t\t\t<h3>
                        設置要點
    \t\t\t\t</h3>
    \t\t\t
    \t\t\t</div>
    \t\t</div>
    \t\t</a>
    \t</div>
\t    <div class=\" col-sm-6 col-md-4 card\">
    \t\t<a href=\"";
        // line 106
        echo $this->env->getExtension('Cms\Twig\Extension')->pageFilter("yda_types");
        echo "\">
    \t\t<div class=\"thumbnail\">
    \t
    \t\t\t<div class=\"caption\" style=\"text-align:center;\">
    \t\t\t\t<h3>
                        設置方式
    \t\t\t\t</h3>
    \t\t\t
    \t\t\t</div>
    \t\t</div>
    \t\t</a>
    \t</div>
\t</div>
</div>
    </div>

</div>


<br />";
        // line 125
        $context['__cms_partial_params'] = [];
        echo $this->env->getExtension('CMS')->partialFunction("cloud"        , $context['__cms_partial_params']        );
        unset($context['__cms_partial_params']);
    }

    public function getTemplateName()
    {
        return "C:\\xampp\\htdocs\\demo/themes/responsiv-flat/pages/advisory_home.htm";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  181 => 125,  159 => 106,  143 => 93,  127 => 80,  101 => 56,  87 => 50,  82 => 47,  79 => 46,  75 => 45,  68 => 40,  64 => 39,  26 => 6,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("<section class=\"home-title\">
    <div class=\"container\">
        <div class=\"row\">
            <div class=\"col-sm-4\">
            
                <a href=\"{{ 'users/nikes'|page }}\"><img src=\"{{ 'assets/images/users/advisor_1.png'|theme }}\"  style=\"width:100%; height: 100%\"></a>
                <p>黃敬峰，從高中開始就被人叫做阿峰，在工作兩年後，被Accupass創辦人與AVEDA台灣代理商負責人說服出來創業，與高中同學林宏諺兩人共同創辦了「共同創辦了「交點」，透過分享的方式，讓更多台灣的年輕人有舞台可以發揮，有麥克風可以分享出屬於自己的故事。從2012年5月至今，已經舉辦超過300場大大小小的聚會活動，透過交點，聽到了全台灣超過6000個故事，600個動人分享！</p>
                
                <!--<div class=\"signup-form\">
                    <form>
                        <div class=\"form-group\">
                            <input class=\"form-control\" type=\"text\" placeholder=\"Your E-mail\">
                        </div>
                        <div class=\"form-group\">
                            <div>
                                <input type=\"password\" class=\"form-control\" placeholder=\"Password\">
                            </div>
                            <div>
                                <input type=\"password\" class=\"form-control\" placeholder=\"Confirmation\">
                            </div>
                        </div>
                        <div class=\"form-group\">
                            <button type=\"submit\" class=\"btn btn-block btn-info\">Sign Up</button>
                        </div>
                    </form>
                </div>
                <div class=\"additional-links\">
                    By signing up you agree to <a href=\"#\">Terms of Use</a> and <a href=\"#\">Privacy Policy</a>
                </div>-->
            </div>
            <!--<div class=\"col-sm-7 col-sm-offset-1 player-wrapper\">
                <div class=\"player\">
                    <iframe src=\"http://player.vimeo.com/video/29568236?color=3498db\" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                </div>                
            </div>-->
            <div id=\"portfolioItems\" class=\"row\">
              
              
           {% partial 'user' %}
                
               
               
        
            </div>
              {% for tag in blogTags.tags %}
 {% set tag_size = tag.posts|length %}
        <div class=\"col-md-2 portfolio-item nature people\">
            <div class=\"picture\">
                <div class=\"description\">
                    <a href=\"/tags/{{ tag.name }}\" class=\"btn btn-info btn-block\">{{ tag.name }}</a>
                </div>
            </div>
        </div>
        
   {% endfor %}
        </div> 
    </div>
</section>


<br />

<div class=\"container\">

    <!-- Services -->
    <div class=\"row our-services\">
        <div class=\"col-sm-12\">
            <h4 class=\"headline\"><span>我們關心的領域</span></h4>
            <!--<p>He hasn't got a freckle my mad as a middy. Trent from punchy maccas no dramas shazza got us some ripper. As dry as a bradman flamin lets throw a cut lunch commando.</p>-->
                  <div id=\"cloudtag\"></div>
            
        </div>
    </div>

    <div class=\"recent-tweets\">
        <h4 class=\"headline\"><span>認識青諮會</span></h4>
 <div class=\"container\">
\t<div class=\"row\">
\t    <div class=\" col-sm-6 col-md-4 card\">
    \t\t<a href=\"{{ 'yda_open'|page }}\">
    \t\t<div class=\"thumbnail\">
    \t
    \t\t\t<div class=\"caption\" style=\"text-align:center;\">
    \t\t\t\t<h3>
                        青諮會緣起
    \t\t\t\t</h3>
    \t\t\t
    \t\t\t</div>
    \t\t</div>
    \t\t</a>
    \t</div>
     <div class=\" col-sm-6 col-md-4 card\">
    \t\t<a href=\"{{ 'yda_points'|page }}\">
    \t\t<div class=\"thumbnail\">
    \t
    \t\t\t<div class=\"caption\" style=\"text-align:center;\">
    \t\t\t\t<h3>
                        設置要點
    \t\t\t\t</h3>
    \t\t\t
    \t\t\t</div>
    \t\t</div>
    \t\t</a>
    \t</div>
\t    <div class=\" col-sm-6 col-md-4 card\">
    \t\t<a href=\"{{ 'yda_types'|page }}\">
    \t\t<div class=\"thumbnail\">
    \t
    \t\t\t<div class=\"caption\" style=\"text-align:center;\">
    \t\t\t\t<h3>
                        設置方式
    \t\t\t\t</h3>
    \t\t\t
    \t\t\t</div>
    \t\t</div>
    \t\t</a>
    \t</div>
\t</div>
</div>
    </div>

</div>


<br />{% partial 'cloud' %}", "C:\\xampp\\htdocs\\demo/themes/responsiv-flat/pages/advisory_home.htm", "");
    }
}
