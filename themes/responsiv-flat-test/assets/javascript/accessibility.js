accessibility = function() {
// 1.1 
    if(document.readyState === 'complete' && document.images.length > 0){
        for(let i=0;i<document.images.length;i++){
            if(document.images[i].title == "" && document.images[i].alt == ""){
                document.images[i].title = document.title
                document.images[i].alt = document.alt
            }
            if (document.images[i].title == "" && document.images[i].alt != "") {
                document.images[i].title = document.images[i].alt
            }
            if (document.images[i].title !="" && document.images[i].alt == ""){
                document.images[i].alt = document.images[i].title
            }
        }
    }

    // 3.3 
    if(document.readyState === 'complete'){
        var icon = document.querySelector(".glyphicon")
        if(icon){
            icon.setAttribute("title", "搜尋")
            icon.setAttribute("alt","搜尋")
        }
    }

    // 3.1 
    if(document.readyState === 'complete'){
        var htag = document.querySelectorAll('h1,h2,h3,h4,h5,h6')
        var h1 = document.getElementsByTagName('h1')
        if (h1.length == 0){
            addh1(htag)
        }else if (h1.length == 1){
            if (htag[0].tagName != 'H1'){
                addh1(htag)
                var tags = document.getElementsByTagName('h1')
                const length = tags.length
                replaceWithHtmlTag(tags, length,'h2', 1)
            }
        }else if(h1.length >1){
            if (htag[0].tagName != 'H1'){
                addh1(htag)
            }
            var tags = document.getElementsByTagName('h1')
            const length = tags.length
            replaceWithHtmlTag(tags, length,'h2', 1)
        }
    }

    if(document.readyState === 'complete'){
        var headers = ['h3','h4','h5','h6']
        headers.forEach((el)=>{
            var tags = document.getElementsByTagName(el)
            if(tags.length >0){
                const length = tags.length
                replaceWithHtmlTag(tags, length, 'h2')
            }  
        })
    }

    function addh1 (htag){
        var tagname = htag[0].tagName
        // var headers= ['h2','h3','h4','h5','h6']
        // var tag = []
        // headers.forEach((el)=>{
        //     if (document.getElementsByTagName(el).length>0){
        //         tag.push(el)
        //     }
        // })
        var tags = document.getElementsByTagName(tagname)
        var windowsize = window.getComputedStyle(tags[0]).fontSize
        var size = Number(windowsize.split('').slice(0,2).join(''))/14.4
        var className = tags[0].className
        var text = tags[0].innerHTML
        if (className == ''){
            html = `<h1 style="font-size:${size}em">${text}</h1>`
        }else{
            html = `<h1 class=${className} style="font-size:${size}em">${text}</h1>`
        }
        $(tags[0]).replaceWith(html)
    }

    function replaceWithHtmlTag(tags, tagsLength, htmltag, index){
        if (!index){
            index =0
        }
        for (let i=0;i<tagsLength; i++){
            // code by pointer so index must be 0
            // console.log(tags[index])
            var windowsize = window.getComputedStyle(tags[index]).fontSize
            var size = Number(windowsize.split('').slice(0,2).join(''))/14.4
            var className = tags[index].className
            var text = tags[index].innerHTML
            if (className == ''){
                html = `<${htmltag} style="font-size:${size}em">${text}</${htmltag}>`
            }else{
                html = `<${htmltag} class=${className} style="font-size:${size}em">${text}</${htmltag}>`
            }
            $(tags[index]).replaceWith(html)    
        }
    }

    //8.1 
    if(document.readyState === 'complete'){
        var navbar = document.getElementsByClassName('navbar navbar-fixed-top')
        var left = document.createElement('a')
        var text = document.createTextNode('跳到主要內容')
        left.appendChild(text)
        var originNav = navbar[0].cloneNode(navbar[0].firstElementChild)
        navbar[0].removeChild(navbar[0].firstElementChild)
        navbar[0].appendChild(left)
        navbar[0].appendChild(originNav)
        var alink = document.getElementsByTagName('a')
        alink[0].tabIndex ="1"
        alink[0].href = '#AC'
        $(alink[0]).css('opacity','0')
        $(alink[0]).focus(()=>{
            $(alink[0]).css('opacity','1')
        })
        $(alink[0]).blur(()=>{
            $(alink[0]).css('opacity','0')
        })
    }

    //8.2  
    if (document.readyState === 'complete'){
        document.title = document.querySelectorAll('h1')[0].innerText
    }

    // 8.3  
    if(document.readyState === 'complete'){
        var right = document.getElementsByClassName('pull-right')
        if (right.length > 0) {
            var parent = right[0].parentNode
            var input = right[0].cloneNode(right[0])
            parent.removeChild(right[0])
            parent.appendChild(input)
        }
    }

    //9.1 
    if (document.readyState === 'complete'){
        var html = document.getElementsByTagName('html')
        html[0].lang = 'zh-Hant'
    }

    //12.1
    if(document.readyState === 'complete' && document.querySelectorAll('noscript').length ==0){
        var el = document.createElement('noscript')
        var text = '您的瀏覽器不支援Javascript功能，若網頁無法正常使用時，請開啟瀏覽器Javascript狀態'
        var node = document.createTextNode(text)
        el.appendChild(node)
        document.body.appendChild(el)    
    }

    //4.1 -- fixed in yda.css
    // if (document.readyState === 'complete'){
    //     var a =document.getElementsByTagName('a')
    //     for (let i= 0; i<a.length;i++){
    //         // if(a[i].firstElementChild != null){
    //         //     if(a[i].firstElementChild.className != null && (window.location.pathname == "/" || window.location.pathname =="/proposal/default")){
    //         //         $(a[i]).css('display','block')
    //         //     }
    //         // }
    //         $(a[i]).focus(()=>{
    //             $(a[i]).css('outline', 'dotted red')
    //         })
    //         $(a[i]).blur(()=>{
    //             $(a[i]).css('outline', 'none')
    //         })
    //     }
    // }
}

window.onload = accessibility;