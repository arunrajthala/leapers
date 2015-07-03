    function PageMe(parentDiv,Page,Per,scroll)
    {
        if(typeof(Page)==='undefined') Page = 1;
        if(typeof(scroll)==='undefined') scroll = true;
        if(typeof(Per)==='undefined') Per = 5;
        //alert('hellow');
        if($(parentDiv+" > div").length<Per)
        {
            return;
        }
        $(parentDiv).children('div').each(function(index,item) {
            //alert(index);
            if(index < (Page-1)*Per || index >((Page)*Per-1) )
            {
                $(item).css('display', 'none');
            }
            else
            {
                $(item).css('display', 'block');
            }
        });
        var PageHtm='<ul>';
        onClk='';
        if(Page!=1)
        {
            onClk="PageMe('"+parentDiv+"',"+(Page-1)+","+Per+")";
            active='ellipse';
        }
        else
        {
            onClk="''";
            active='current';
        }
        PageHtm+="<li onclick="+onClk+" class='prev "+active+"'><span>Prev</span></li>";
        var ct=1;
        for(i=0;i<$(parentDiv+" > div").length;i+=Per)
        {
            if(Page==ct)
            {
                active='active current';
                onClk="''";
            }
            else
            {
                active='ellipse';
                onClk="PageMe('"+parentDiv+"',"+(ct)+","+Per+")";
            }
            PageHtm+="<li onclick="+onClk+" class='"+active+"'><span>"+(ct)+"</span></li>";
            ct++;
        }
        onClk='';
        if(Page<(ct-1))
        {
            onClk="PageMe('"+parentDiv+"',"+(Page+1)+","+Per+")";
            active='ellipse';
        }
        else
        {
            onClk="''";
            active='current';
            
        }
        PageHtm+="<li onclick="+onClk+" class='next "+active+"'><span >Next</span></li>";
        //PageHtm+='<li class="next">Next</li>'
        PageHtm+='</ul>';
        $('.Pagination').html(PageHtm);
        if(scroll ==true)
        {
            $("html, body").animate({ scrollTop: 500 }, "slow");
        }
        //window.scrollTo(0, 500);
    }
    function PageMe_Dynamic(TotalPage,Page,Per,scroll,id,where)
    {
        
        if(typeof(Page)==='undefined') Page = 1;
        if(typeof(scroll)==='undefined') scroll = true;
        if(typeof(Per)==='undefined') Per = 5;
        if(typeof(where)==='undefined') where = '';
        if(typeof(Order)==='undefined') Order = '';
        if(typeof(moduleName)==='undefined') moduleName = '';
        
        //alert(TotalPage);
        
        var PageHtm='';
        onClk='';
        if(Page!=1)
        {
            onClk="PageMe_Dynamic('"+TotalPage+"',"+(Page-1)+","+Per+",true,'"+id+"','"+where+"')";
            active='ellipse';
        }
        else
        {
            onClk="''";
            active='active';
        }
        PageHtm+="<li onclick="+onClk+" class='prev "+active+"'><span>Prev</span></li>";
        
        var ct=1;
        for(i=0;i<TotalPage;i++)
        {
            if(Page==ct)
            {
                active='active current';
                onClk="''";
            }
            else
            {
                active='ellipse';
                onClk="PageMe_Dynamic('"+TotalPage+"',"+ct+","+Per+",true,'"+id+"','"+where+"')";
            }
            if(TotalPage>15)
            {
                //alert(ct);
                if(ct>(Page-3) && ct<(Page+3))
                {
                    PageHtm+="<li onclick="+onClk+" class='"+active+"'><span>"+(ct)+"</span></li>";
                }
                else
                {
                    if(ct<4|| ct>(TotalPage-3))
                    {
                        PageHtm+="<li onclick="+onClk+" class='"+active+"'><span>"+(ct)+"</span></li>";    
                    }
                    else
                    {
                        if(ct==4 || ct==(TotalPage-3))
                        PageHtm+= '<li ><span>...</span></li>';
                    }
                }
                
            }
            else
            {
                PageHtm+="<li onclick="+onClk+" class='"+active+"'><span>"+(ct)+"</span></li>";
            }
            
            ct++;
        }
        onClk='';
        if(Page<(ct-1))
        {
            onClk="PageMe_Dynamic('"+TotalPage+"',"+(Page+1)+","+Per+",true,'"+id+"')";
            active='ellipse';
        }
        else
        {
            onClk="''";
            active='active';
            
        }
        PageHtm+="<li onclick="+onClk+" class='next "+active+"'><span >Next</span></li>";
        //PageHtm+='<li class="next">Next</li>'
        //console.log(PageHtm);
        PageHtm+='';
        if(TotalPage>1)
        {
            $('.pagination').html(PageHtm);
        }
        if(typeof(id)!='undefined') 
        {
            //console.log('getting news_dynamic');
            if(id!='')
            {
                getNews_Dynamic('news02news01uin='+id,'',Page,Per);
            }
            else
            {
                getNews_Dynamic('','',Page,Per);
            }
            
        }
        else
        {
            //alert(Condition);
            getArticle_Dynamic(prefix,module,uploadURL,Condition,Order,Page,Per,scroll,moduleName)
        }
        position = $('#newsList').position();
        
        if(scroll ==true)
        {
            $("html, body").animate({ scrollTop: position.top }, "slow");
        }
        //window.scrollTo(0, 500);
    }
    
    function getNews_Dynamic(Condition,Order,Page,Per,scroll)
    {
        //console.log('reached getNews_Dynamic');
        if(typeof(Page)==='undefined') Page = 1;
        if(typeof(scroll)==='undefined') scroll = true;
        if(typeof(Per)==='undefined') Per = 5;
        if(typeof(Order)==='undefined') Order = '';
        $( "#newsList" ).load( "ajax/NewsList.php?page="+Page+"&per="+Per+"&where="+Condition+"&order="+Order );
        
        //var obj = $.parseJSON(response)
    }
    function PageMe_Dynamic_pub(TotalPage,Page,Per,scroll,prefix,module,uploadURL,moduleName,Condition,Order)
    {
        if(typeof(Page)==='undefined') Page = 1;
        if(typeof(scroll)==='undefined') scroll = true;
        if(typeof(Per)==='undefined') Per = 5;
        if(typeof(Condition)==='undefined') Condition = '';
        if(typeof(Order)==='undefined') Order = '';
        if(typeof(moduleName)==='undefined') moduleName = '';
        
        //alert(TotalPage);
        
        var PageHtm='<ul>';
        
        onClk='';
        if(Page!=1)
        {
            onClk="PageMe_Dynamic('"+TotalPage+"',"+(Page-1)+","+Per+")";
            active='ellipse';
        }
        else
        {
            onClk="''";
            active='current';
        }
        PageHtm+="<li onclick="+onClk+" class='prev "+active+"'><span>Prev</span></li>";
        var ct=1;
        for(i=0;i<TotalPage;i+=Per)
        {
            if(Page==ct)
            {
                active='active current';
                onClk="''";
            }
            else
            {
                active='ellipse';
                onClk="PageMe_Dynamic('"+TotalPage+"',"+(ct)+","+Per+")";
            }
            PageHtm+="<li onclick="+onClk+" class='"+active+"'><span>"+(ct)+"</span></li>";
            ct++;
        }
        
        onClk='';
        if(Page<(ct-1))
        {
            onClk="PageMe_Dynamic('"+TotalPage+"',"+(Page+1)+","+Per+")";
            active='ellipse';
        }
        else
        {
            onClk="''";
            active='current';
            
        }
        PageHtm+="<li onclick="+onClk+" class='next "+active+"'><span >Next</span></li>";
        //PageHtm+='<li class="next">Next</li>'
        PageHtm+='</ul>';
        if(TotalPage>1)
        {
            $('.Pagination').html(PageHtm);
        }
        if(typeof(module)==='undefined') 
        {
            getNews_Dynamic_Publication('','',Page,Per);
        }
        else
        {
            //alert(Condition);
            getArticle_Dynamic(prefix,module,uploadURL,Condition,Order,Page,Per,scroll,moduleName)
        }
        position = $('#newsList').position();
        
        if(scroll ==true)
        {
            $("html, body").animate({ scrollTop: position.top }, "slow");
        }
        //alert('bye');
        //window.scrollTo(0, 500);
    }
    function getNews_Dynamic_Publication(Condition,Order,Page,Per,scroll)
    {
        if(typeof(Page)==='undefined') Page = 1;
        if(typeof(scroll)==='undefined') scroll = true;
        if(typeof(Per)==='undefined') Per = 5;
        if(typeof(Order)==='undefined') Order = '';
        $( "#newsList" ).load( "ajax/Publication.php?page="+Page+"&per="+Per+"&where="+Condition+"&order="+Order );
        
        //var obj = $.parseJSON(response)
    }
    function getArticle_Dynamic(Prefix,Module,uploadURL,Condition,Order,Page,Per,scroll,moduleName)
    {
        if(typeof(Page)==='undefined') Page = 1;
        if(typeof(scroll)==='undefined') scroll = true;
        if(typeof(Per)==='undefined') Per = 5;
        if(typeof(Order)==='undefined') Order = '';
        $( "#newsList" ).load( "ajax/ArticleList.php?page="+Page+"&per="+Per+"&where="+Condition+"&order="+Order+"&module="+Module+"&prefix="+Prefix +"&upURL="+uploadURL+"&moduleName="+moduleName);
        
        //var obj = $.parseJSON(response)
    }