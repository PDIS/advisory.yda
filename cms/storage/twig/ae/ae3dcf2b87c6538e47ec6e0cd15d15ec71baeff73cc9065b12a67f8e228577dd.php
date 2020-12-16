<?php

/* C:\xampp\htdocs\demo/themes/responsiv-flat/partials/cloud.htm */
class __TwigTemplate_8fb6f02a16378945183e90aebfb171fe6506ed9a7d65a0443a44e29b814828e1 extends Twig_Template
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
        echo "<link href=\"";
        echo $this->env->getExtension('Cms\Twig\Extension')->themeFilter(array(0 => "assets/css/cloud.css"));
        echo "\" rel=\"stylesheet\">

<head>  
        <meta charset=\"utf-8\">  
        <title></title>  
        
          <script src=\"//d3plus.org/js/d3.js\"></script>

     
        <style type=\"text/css\"> 
            text{  
                font-size: 24px;  
            }  
        </style>  
    </head>  
    <body>  
        <script type=\"text/javascript\">  
            
           var diameter = 960,                                 //設置寬高 
                color = d3.scale.category20c();                 //設置不同顏色  
            /*佈局設置*/  
            var bubble = d3.layout.pack()                       //初始化包圖                         
                .sort(null)                                     //後面的數減去前面的數排序，正負都變，null序不變
                .size([diameter, diameter])                     //設置範圍 
                .padding(1.5);                                  //設置間距
            /*獲取並添加SVG元素，並設置寬高*/
            var svg = d3.select(\"#cloudtag\").append(\"div\")
            
            .append(\"svg\")
 .attr(\"preserveAspectRatio\", \"xMinYMin meet\")
   .attr(\"viewBox\", \"0 0 960 960\")
   //class to make it responsive
   .classed(\"svg-content-responsive\", true)
            .attr(\"class\", \"bubble\"); 
            /*假定後台傳入的數據*/    
            var data = {創意育成: 50, 原住民: 20, 綠能源: 30, 技職: 40, 高齡:20, 社會企業:40,教育: 40};  
            /*entries可以將如上類型的格式轉換成{key:名稱,value:343434}的array*/  
            var result = d3.entries(data);  
            /*以下是字符串拼接*/  
            var startString = \"{\\\"name\\\": \\\"flare\\\",\\\"children\\\": [\";                      //開頭字符串  
            result.forEach(function(dude){                                                 //遍歷結果並且拼接
                startString+=\"{\\\"name\\\":\\\"\"+dude.key+\"\\\",\\\"size\\\":\"+dude.value+\"},\";  
            })  
            /*去除最後一個末尾的逗號，這個逗號會影響後面JSON.parse的使用*/ 
            startString = startString.substring(0,startString.length-1);  
            /*拼接尾部字符串*/
            startString+=\"]}\";  
           /*將拼接好的字符串轉換成JSON對象*/  
            var json2 = JSON.parse(startString);  
            /*繪圖部分*/
            console.log(classes(json2));  
            var node = svg.selectAll(\".node\")  
                          .data(bubble.nodes(classes(json2))                                                                 //綁定數據（配置結點）  
                          .filter(function(d) { return !d.children; }))                                                     //數據過濾，滿足條件返回自身（沒孩子返回自身，有孩子不返回，這裡目的是去除父節點）  
                          .enter().append(\"g\")  
                          .attr(\"class\", \"node\")  
                          .attr(\"transform\", function(d) { return \"translate(\" + d.x + \",\" + d.y + \")\"; });                  //設定g移動 
                  
                node.append(\"title\")  
                    .text(function(d) { return d.className + \": \" + (d.value); });             //設置移入時候顯示數據 數據名和值 
                  
                node.append(\"circle\")  
                    .attr(\"r\", function(d) { return d.r;})                                     //設置圓的半徑
                    .style(\"fill\", function(d) { return color(d.value); });              //為圓形塗色
                  
                node.append(\"text\")  
                    .attr(\"dy\", \".3em\")  
                    .style(\"text-anchor\", \"middle\")                                            //設置文本對齊  
                    .text(function(d) { return d.className.substring(0, d.r / 3); });          //根據半徑的大小來截取對應長度字符串（很重要）  
  
                // Returns a flattened hierarchy containing all leaf nodes under the root.  
                function classes(root) {  
                    var classes = [];                                                                                        //存儲結果的數組 
                    /*自定義遞歸函數
                     * 
                     * 第二個參數指傳入的json對象 
                     * */  
                    function recurse(name, node) {  
                        if (node.children)                                                                                   //如果有孩子結點 （這裡的children不是自帶的，是json裡面有的） 
                        {  
                            node.children.forEach(function(child) {                                                          //將孩子結點中的每條數據
                                recurse(node.name, child); })  
                        }  
                        else {classes.push({ className: node.name, value: node.size})};                                     //如果自身是孩子結點的，將內容壓入數組 
                    }  
                    recurse(null, root);  
                    return {children: classes};                                                                             //返回所有的子節點 （包含在children中）                                                                           
                }  
        </script>  
    </body>";
    }

    public function getTemplateName()
    {
        return "C:\\xampp\\htdocs\\demo/themes/responsiv-flat/partials/cloud.htm";
    }

    public function isTraitable()
    {
        return false;
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
        return new Twig_Source("<link href=\"{{ ['assets/css/cloud.css']|theme }}\" rel=\"stylesheet\">

<head>  
        <meta charset=\"utf-8\">  
        <title></title>  
        
          <script src=\"//d3plus.org/js/d3.js\"></script>

     
        <style type=\"text/css\"> 
            text{  
                font-size: 24px;  
            }  
        </style>  
    </head>  
    <body>  
        <script type=\"text/javascript\">  
            
           var diameter = 960,                                 //設置寬高 
                color = d3.scale.category20c();                 //設置不同顏色  
            /*佈局設置*/  
            var bubble = d3.layout.pack()                       //初始化包圖                         
                .sort(null)                                     //後面的數減去前面的數排序，正負都變，null序不變
                .size([diameter, diameter])                     //設置範圍 
                .padding(1.5);                                  //設置間距
            /*獲取並添加SVG元素，並設置寬高*/
            var svg = d3.select(\"#cloudtag\").append(\"div\")
            
            .append(\"svg\")
 .attr(\"preserveAspectRatio\", \"xMinYMin meet\")
   .attr(\"viewBox\", \"0 0 960 960\")
   //class to make it responsive
   .classed(\"svg-content-responsive\", true)
            .attr(\"class\", \"bubble\"); 
            /*假定後台傳入的數據*/    
            var data = {創意育成: 50, 原住民: 20, 綠能源: 30, 技職: 40, 高齡:20, 社會企業:40,教育: 40};  
            /*entries可以將如上類型的格式轉換成{key:名稱,value:343434}的array*/  
            var result = d3.entries(data);  
            /*以下是字符串拼接*/  
            var startString = \"{\\\"name\\\": \\\"flare\\\",\\\"children\\\": [\";                      //開頭字符串  
            result.forEach(function(dude){                                                 //遍歷結果並且拼接
                startString+=\"{\\\"name\\\":\\\"\"+dude.key+\"\\\",\\\"size\\\":\"+dude.value+\"},\";  
            })  
            /*去除最後一個末尾的逗號，這個逗號會影響後面JSON.parse的使用*/ 
            startString = startString.substring(0,startString.length-1);  
            /*拼接尾部字符串*/
            startString+=\"]}\";  
           /*將拼接好的字符串轉換成JSON對象*/  
            var json2 = JSON.parse(startString);  
            /*繪圖部分*/
            console.log(classes(json2));  
            var node = svg.selectAll(\".node\")  
                          .data(bubble.nodes(classes(json2))                                                                 //綁定數據（配置結點）  
                          .filter(function(d) { return !d.children; }))                                                     //數據過濾，滿足條件返回自身（沒孩子返回自身，有孩子不返回，這裡目的是去除父節點）  
                          .enter().append(\"g\")  
                          .attr(\"class\", \"node\")  
                          .attr(\"transform\", function(d) { return \"translate(\" + d.x + \",\" + d.y + \")\"; });                  //設定g移動 
                  
                node.append(\"title\")  
                    .text(function(d) { return d.className + \": \" + (d.value); });             //設置移入時候顯示數據 數據名和值 
                  
                node.append(\"circle\")  
                    .attr(\"r\", function(d) { return d.r;})                                     //設置圓的半徑
                    .style(\"fill\", function(d) { return color(d.value); });              //為圓形塗色
                  
                node.append(\"text\")  
                    .attr(\"dy\", \".3em\")  
                    .style(\"text-anchor\", \"middle\")                                            //設置文本對齊  
                    .text(function(d) { return d.className.substring(0, d.r / 3); });          //根據半徑的大小來截取對應長度字符串（很重要）  
  
                // Returns a flattened hierarchy containing all leaf nodes under the root.  
                function classes(root) {  
                    var classes = [];                                                                                        //存儲結果的數組 
                    /*自定義遞歸函數
                     * 
                     * 第二個參數指傳入的json對象 
                     * */  
                    function recurse(name, node) {  
                        if (node.children)                                                                                   //如果有孩子結點 （這裡的children不是自帶的，是json裡面有的） 
                        {  
                            node.children.forEach(function(child) {                                                          //將孩子結點中的每條數據
                                recurse(node.name, child); })  
                        }  
                        else {classes.push({ className: node.name, value: node.size})};                                     //如果自身是孩子結點的，將內容壓入數組 
                    }  
                    recurse(null, root);  
                    return {children: classes};                                                                             //返回所有的子節點 （包含在children中）                                                                           
                }  
        </script>  
    </body>", "C:\\xampp\\htdocs\\demo/themes/responsiv-flat/partials/cloud.htm", "");
    }
}
