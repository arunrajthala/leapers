$(document).ready(function() {
	$('#vertical-ticker').totemticker({
				row_height	:	'100px',
				next		:	'#ticker-next',
				previous	:	'#ticker-previous',
				stop		:	'#stop',
				start		:	'#start',
				mousestop	:	true,
			});
	$("#webticker").webTicker();
	$('a[href=#top]').click(function(){
	$('html, body').animate({scrollTop:0}, 'slower');
		return false;
		});
		$(window).bind('scroll', function(){
		if($(this).scrollTop() > 50) {
		$(".to-top").fadeIn("1000");
		}
		else{
		$(".to-top").fadeOut("2000");
		}
		}
	);
	$("#amazon_scroller3").amazon_scroller({
		scroller_title_show: 'enable',
		scroller_time_interval: '3000',
		scroller_window_background_color: "none",
		scroller_window_padding: '10',
		scroller_border_size: '0',
		scroller_border_color: '#9C6',
		scroller_images_width: '120',
		scroller_images_height: '99',
		scroller_title_size: '16',
		scroller_title_color: 'black',
		scroller_show_count: '6',
		directory: 'images'
	});
			
});
//news ticker
	(function( $ ){

	var cssTransitionsSupported = (function() {
	    var s = document.createElement('p').style, 
	        v = ['ms','O','Moz','Webkit']; 

	    if( s['transition'] == '' ) return true; 
	    while( v.length ) 
	        if( v.pop() + 'Transition' in s )
	            return true;
	    return false;
	})();

	function scrollitems($strip,moveFirst){
		var settings = $strip.data('settings');
		if (typeof moveFirst === 'undefined')
			moveFirst = false;
		if (moveFirst){
			moveFirstElement($strip);
		}
		var options = animationSettings($strip);
		$strip.animate(options.css, options.time, "linear", function(){
			$strip.css(settings.direction, '0');
			scrollitems($strip,true);
		});
	}

	function animationSettings($strip){
		var settings = $strip.data('settings');
		var first = $strip.children().first();
		var distance =  Math.abs(-$strip.css(settings.direction).replace('px','').replace('auto','0') - first.outerWidth(true));
		var settings = $strip.data('settings');
		var timeToComplete = distance * 1000 / settings.speed;
		var animationSettings = {};
		animationSettings[settings.direction] = $strip.css(settings.direction).replace('px','').replace('auto','0') - distance;
		return {'css':animationSettings,'time':timeToComplete};
	}

	function moveFirstElement($strip){
		var settings = $strip.data('settings');
		$strip.css('transition-duration','0s').css(settings.direction, '0');
		var $first = $strip.children().first();
		if ($first.hasClass('webticker-init'))
			$first.remove();
		else 
			$strip.children().last().after($first);
	}

	function css3Scroll($strip,moveFirst){
		if (typeof moveFirst === 'undefined')
			moveFirst = false;
		if (moveFirst){
			moveFirstElement($strip);
		}
		var options = animationSettings($strip);
		var time = options.time/1000;
		time += 's'; 
		$strip.css(options.css).css('transition-duration',time);
	}

	function updaterss(rssurl,type,$strip){
		var list;
		$.get(rssurl, function(data) {
		    var $xml = $(data);
		    $xml.find("item").each(function() {
		        var $this = $(this),
		            item = {
		                title: $this.find("title").text(),
		                link: $this.find("link").text()
		        }
		        listItem = "<li><a href='"+item.link+"'>"+item.title+"</a></li>";
		        list += listItem;
		        //Do something with item here...
		    });
			$strip.webTicker('update', list, type);
		});
	}

	function initalize($strip){
		var settings = $strip.data('settings');
		
		$strip.width('auto');
		
		//Find the real width of all li elements
		var stripWidth = 0;
		$strip.children('li').each(function(){
			stripWidth += $(this).outerWidth( true );
		}); 
		
		if(stripWidth < $strip.parent().width() || $strip.children().length == 1){
			//if duplicate items
			if (settings.duplicate){
				//Check how many times to duplicate depending on width.
				itemWidth = Math.max.apply(Math, $strip.children().map(function(){ return $(this).width(); }).get());
				while (stripWidth - itemWidth < $strip.parent().width() || $strip.children().length == 1){
					var listItems = $strip.children().clone();
					$strip.append(listItems);
					stripWidth = 0;
					$strip.children('li').each(function(){
						stripWidth += $(this).outerWidth( true );
					});
					itemWidth = Math.max.apply(Math, $strip.children().map(function(){ return $(this).width(); }).get());
				}
			}else {
				//if fill with empty padding
				var emptySpace = $strip.parent().width() - stripWidth;
				emptySpace += $strip.find("li:first").width();
				var height = $strip.find("li:first").height();

				$strip.append('<li class="ticker-spacer" style="width:'+emptySpace+'px;height:'+height+'px;"></li>');
			}
		}
		if (settings.startEmpty){
			var height = $strip.find("li:first").height();
			$strip.prepend('<li class="webticker-init" style="width:'+$strip.parent().width()+'px;height:'+height+'px;"></li>');
		}
		//extra width to be able to move items without any jumps	$strip.find("li:first").width()	

		stripWidth = 0;
		$strip.children('li').each(function(){
			stripWidth += $(this).outerWidth( true );
		});	
		$strip.width(stripWidth+200);
		widthCompare = 0;
		$strip.children('li').each(function(){
			widthCompare += $(this).outerWidth( true );
		});	
		//loop to find weather the items inside the list are actually bigger then the size of the whole list. Increments in 200px.
		//only required when a single item is bigger then the whole list
		while (widthCompare >= $strip.width()){
			$strip.width($strip.width()+200);
			widthCompare = 0;
			$strip.children('li').each(function(){
				widthCompare += $(this).outerWidth( true );
			});	
		}
	}

  var methods = {
    init : function( settings ) { // THIS 
		settings = jQuery.extend({
			speed: 50, //pixels per second
			direction: "left",
			moving: true,
			startEmpty: true,
			duplicate: false,
			rssurl: false,
			hoverpause: true,
			rssfrequency: 0,
			updatetype: "reset"
		}, settings);
		//set data-ticker a unique ticker identifier if it does not exist
		return this.each(function(){
			jQuery(this).data('settings',settings);

				var $strip = jQuery(this);
				$strip.addClass("newsticker");
				var $mask = $strip.wrap("<div class='mask'></div>");
				$mask.after("<span class='tickeroverlay-left'>&nbsp;</span><span class='tickeroverlay-right'>&nbsp;</span>")
				var $tickercontainer = $strip.parent().wrap("<div class='tickercontainer'></div>");	
				
				initalize($strip);
				
				if (settings.rssurl){
					updaterss(settings.rssurl,settings.type,$strip);
					if (settings.rssfrequency>0){
						window.setInterval(function(){updaterss(settings.rssurl,settings.type,$strip);},settings.rssfrequency*1000*60);
					}
				}

				if (cssTransitionsSupported){
					//fix for firefox not animating default transitions
					$strip.css('transition-duration','0s').css(settings.direction, '0');
					css3Scroll($strip,false);
					$strip.on('transitionend webkitTransitionEnd oTransitionEnd otransitionend', function(event) {
						if (!$strip.is(event.target)) {
							return false;
						}
						css3Scroll($(this),true);
					});
				} else {
					scrollitems($(this));
				}

				if (settings.hoverpause){
					$strip.hover(function(){
						if (cssTransitionsSupported){
							var currentPosition = $(this).css(settings.direction);
							$(this).css('transition-duration','0s').css(settings.direction,currentPosition);
						} else 
							jQuery(this).stop();
					},
					function(){
						if (jQuery(this).data('settings').moving){
							if (cssTransitionsSupported){
								css3Scroll($(this),false);
								// $(this).css("-webkit-animation-play-state", "running");
							} else {
								//usual continue stuff
								scrollitems($strip)
							}
						}
					});	
				}
		});
	},
    stop : function( ) { 
    	var settings = $(this).data('settings');
		if (settings.moving){
			settings.moving = false;
			return this.each(function(){
				if (cssTransitionsSupported){
					var currentPosition = $(this).css(settings.direction);
					$(this).css('transition-duration','0s').css(settings.direction,currentPosition);
				} else 
					$(this).stop();
			});
		}
	},
    cont : function( ) {
    	var settings = $(this).data('settings')
		if (!settings.moving){
			settings.moving = true;
			return this.each(function(){
				if (cssTransitionsSupported){
					css3Scroll($(this),false);
				} else {
					scrollitems($(this));
				}
			});	
		}
	},
	update : function( list, type, insert, remove) { 
		type = type || "reset";
		if (typeof insert === 'undefined')
			insert = true;
		if (typeof remove === 'undefined')
			remove = false;
		if( typeof list === 'string' ) {
		    list = $(list);
		}
		var $strip = $(this);
		$strip.webTicker('stop');
		var settings = $(this).data('settings');
		if (type == 'reset'){
			//this does a 'restart of the ticker'
			$strip.html(list);
			$strip.css(settings.direction, '0');
			initalize($strip);
		} else if (type == 'swap'){
			// should the update be a 'hot-swap' or use replacement for IDs (in which case remove new ones)
			$strip.children('li').addClass('old');
			for (var i = 0; i < list.length; i++) {
				id = $(list[i]).data('update');
				match = $strip.find('[data-update="'+id+'"]');//should try find the id or data-attribute.
				if (match.length < 1){
					if (insert){
						//we need to move this item into the dom
						if ($strip.find('.ticker-spacer:first-child').length == 0 && $strip.find('.ticker-spacer').length > 0){
							$strip.children('li.ticker-spacer').before(list[i]);
						}
						else {
							$strip.append(list[i]);
						}
					}
				} else $strip.find('[data-update="'+id+'"]').replaceWith(list[i]);;
			};
			$strip.children('li.webticker-init, li.ticker-spacer').removeClass('old');
			if (remove)
				$strip.children('li').remove('.old');
			stripWidth = 0;
			$strip.children('li').each(function(){
				stripWidth += $(this).outerWidth( true );
			});	
			$strip.width(stripWidth+200);
		}
		
		$strip.webTicker('cont');
	}
  };

  $.fn.webTicker = function( method ) {
    
    // Method calling logic
    if ( methods[method] ) {
      return methods[ method ].apply( this, Array.prototype.slice.call( arguments, 1 ));
    } else if ( typeof method === 'object' || ! method ) {
      return methods.init.apply( this, arguments );
    } else {
      $.error( 'Method ' +  method + ' does not exist on jQuery.webTicker' );
    }    
  
  };

	})( jQuery );
	
//amazon slider
(function(a){
    a.fn.amazon_scroller=function(p){
        var p=p||{};

        var g=p&&p.scroller_time_interval?p.scroller_time_interval:"3000";
        var h=p&&p.scroller_title_show?p.scroller_title_show:"enable";
        var i=p&&p.scroller_window_background_color?p.scroller_window_background_color:"white";
        var j=p&&p.scroller_window_padding?p.scroller_window_padding:"5";
        var k=p&&p.scroller_border_size?p.scroller_border_size:"1";
        var l=p&&p.scroller_border_color?p.scroller_border_color:"black";
        var m=p&&p.scroller_images_width?p.scroller_images_width:"70";
        var n=p&&p.scroller_images_height?p.scroller_images_height:"50";
        var o=p&&p.scroller_title_size?p.scroller_title_size:"12";
        var q=p&&p.scroller_title_color?p.scroller_title_color:"blue";
        var r=p&&p.scroller_show_count?p.scroller_show_count:"3";
        var d=p&&p.directory?p.directory:"images";
        j += "px";
        k += "px";
        m += "px";
        n += "px";
        o += "px";
        var dom=a(this);
        var s;
        var t=0;
        var u;
        var v;
        var w=dom.find("ul:first").children("li").length;
        var x=Math.ceil(w/r);
        if(dom.find("ul").length==0||dom.find("li").length==0){
            dom.append("Require content");
            return null
        }
        dom.find("ul:first").children("li").children("a").children("img").css("width",m).css("height",n);
        if(h=='enable'){
            dom.find("ul:first").children("li").children("a").each(function(){
                $(this).append('<div class="amazon_scroller_title">'+$(this).attr("title")+'</div>')
            })
			dom.find("ul:first").children("li").css("height",n+o+"px");
        }else{
			dom.find("ul:first").children("li").css("height",n+"px");
		}
		dom.find(".amazon_scroller_title").height(parseInt(o)+"px");
        s_s_ul(dom,j,k,l,i);
        s_s_nav(dom.find(".amazon_scroller_nav"),d);
        m=parseInt(m);
        dom.find("ul:first").children("li").css("width",m+"px");
        n=parseInt(n);
        
        dom.find("ul:first").children("li").children("a").css("color",q);
        dom.find("ul:first").children("li").children("a").css("font-size",o);
        begin();
        s=setTimeout(play,g);
        dom.find(".amazon_scroller_nav").children("li").hover(
            function(){
                if($(this).parent().children().index($(this))==0){
                    $(this).css("background-position","left -50px");
                }else if($(this).parent().children().index($(this))==1){
                    $(this).css("background-position","right -50px");
                }
            },
            function(){
                if($(this).parent().children().index($(this))==0){
                    $(this).css("background-position","left top");
                }else if($(this).parent().children().index($(this))==1){
                    $(this).css("background-position","right top");
                }
            }
            );
        dom.find(".amazon_scroller_nav").children("li").click(function(){
            if($(this).parent().children().index($(this))==0){
                previous()
            }else if($(this).parent().children().index($(this))==1){
                next()
            }
        });
        dom.hover(
            function(){
                clearTimeout(s);
            },
            function(){
                s=setTimeout(play,g);
            }
        );
        function begin(){
            var a=dom.find("ul:first").children("li").outerWidth(true)*w;
            dom.find("ul:first").children("li").hide();
            dom.find("ul:first").children("li").slice(0,r).show();
            u=dom.find("ul:first").outerWidth();
            v=dom.find("ul:first").outerHeight();
            dom.find("ul:first").width(a);
            dom.width(u+60);
            dom.height(v);
            dom.children(".amazon_scroller_mask").width(u);
            dom.children(".amazon_scroller_mask").height(v);
            dom.find("ul:first").children("li").show();
            dom.css("position","relative");
            dom.find("ul:first").css("position","absolute");
            dom.children(".amazon_scroller_mask").width(u);
            dom.children(".amazon_scroller_mask").height(v);
            dom.find(".amazon_scroller_nav").css('top',(v-50)/2+parseInt(j)+"px");
            dom.find(".amazon_scroller_nav").width(u+60)
			dom.find("ul:first").clone().appendTo(dom.children(".amazon_scroller_mask"));
			dom.children(".amazon_scroller_mask").find("ul:last").css("left",a);
        }
        function previous(){
			clearTimeout(s);
			if(t > 0){
				t--;
				dom.children(".amazon_scroller_mask").find("ul").animate({
	                left: '+='+(m+10)
	            },500);
			}
        }
        function next(){
            play();
        }
        function play(){
            clearTimeout(s);
			t++;
			var a = dom.find("ul:first").children("li").outerWidth(true)*w;
            if(t >= w+1){
				t = 0;
				dom.children(".amazon_scroller_mask").find("ul:first").css("left","0px");
				dom.children(".amazon_scroller_mask").find("ul:last").css("left",a);
				s=setTimeout(play,0);
            }else{
				dom.children(".amazon_scroller_mask").find("ul").animate({
	                left: '-='+(m+10)
	            },500);
				s=setTimeout(play,g);
			}
        }
        function s_s_ul(a,b,c,d,e){
            b=parseInt(b);
            c=parseInt(c);
            var f="border: "+d+" solid "+" "+c+"px; padding:"+b+"px; background-color:"+e;
            a.attr("style",f)
        }
        function s_s_nav(a,d){
            var b=a.children("li:first");
            var c=a.children("li:last");
            a.children("li").css("width","25px");
            a.children("li").css("height","50px");
            a.children("li").css('background-image','url("'+d+'/arrow.gif")');
            c.css('background-position','right top');
            a.children("li").css('background-repeat','no-repeat');
            c.css('right','0px');
            b.css('left','0px');
        }
    }
})(jQuery);
(function( $ ){
	
	if(!$.omr){
		$.omr = new Object();
	};

	$.omr.totemticker = function(el, options ) {
	  	
	  	var base = this;
	  	
		//Define the DOM elements
	  	base.el = el;
	  	base.$el = $(el);
	  	
	  	// Add a reverse reference to the DOM object
        base.$el.data("omr.totemticker", base);
	  	
	  	base.init = function(){
            base.options = $.extend({},$.omr.totemticker.defaultOptions, options);
            
            //Define the ticker object
           	base.ticker;
			
			//Adjust the height of ticker if specified
			base.format_ticker();
			
			//Setup navigation links (if specified)
			base.setup_nav();
			
			//Start the ticker
			base.start_interval();
			
			//Debugging info in console
			//base.debug_info();
        };
		
		base.start_interval = function(){
			
			//Clear out any existing interval
			clearInterval(base.ticker);
			
	    	base.ticker = setInterval(function() {
	    	
	    		base.$el.find('li:first').animate({
	            	marginTop: '-' + base.options.row_height,
	            }, base.options.speed, function() {
	                $(this).detach().css('marginTop', '0').appendTo(base.$el);
	            });
	            
	    	}, base.options.interval);
	    }
	    
	    base.reset_interval = function(){
	    	clearInterval(base.ticker);
	    	base.start_interval();
	    }
	    
	    base.stop_interval = function(){
	    	clearInterval(base.ticker);
	    }
	
		base.format_ticker = function(){
		
			if(typeof(base.options.max_items) != "undefined" && base.options.max_items != null) {
				
				//Remove units of measurement (Should expand to cover EM and % later)
				var stripped_height = base.options.row_height.replace(/px/i, '');
				var ticker_height = stripped_height * base.options.max_items;
			
				base.$el.css({
					height		: ticker_height + 'px', 
					overflow	: 'hidden',	
				});
				
			}else{
				//No heights were specified, so just doublecheck overflow = hidden
				base.$el.css({
					overflow	: 'hidden',
				})
			}
			
		}
	
		base.setup_nav = function(){
			
			//Stop Button
			if (typeof(base.options.stop) != "undefined"  && base.options.stop != null){
				$(base.options.stop).click(function(){
					base.stop_interval();
					return false;
				});
			}
			
			//Start Button
			if (typeof(base.options.start) != "undefined"  && base.options.start != null){
				$(base.options.start).click(function(){
					base.start_interval();
					return false;
				});
			}
			
			//Previous Button
			if (typeof(base.options.previous) != "undefined"  && base.options.previous != null){
				$(base.options.previous).click(function(){
					base.$el.find('li:last').detach().prependTo(base.$el).css('marginTop', '-' + base.options.row_height);
					base.$el.find('li:first').animate({
				        marginTop: '0px',
				    }, base.options.speed, function () {
				        base.reset_interval();
				    });
				    return false;
				});
			}
			
			//Next Button
			if (typeof(base.options.next) != "undefined" && base.options.next != null){
				$(base.options.next).click(function(){
					base.$el.find('li:first').animate({
						marginTop: '-' + base.options.row_height,
			        }, base.options.speed, function() {
			            $(this).detach().css('marginTop', '0px').appendTo(base.$el);
			            base.reset_interval();
			        });
			        return false;
				});
			}
			
			//Stop on mouse hover
			if (typeof(base.options.mousestop) != "undefined" && base.options.mousestop === true) {
				base.$el.mouseenter(function(){
					base.stop_interval();
				}).mouseleave(function(){
					base.start_interval();
				});
			}
			
			/*
				TO DO List
				----------------
				Add a continuous scrolling mode
			*/
			
		}
		
		base.debug_info = function()
		{
			//Dump options into console
			console.log(base.options);
		}
		
		//Make it go!
		base.init();
  };
  
  $.omr.totemticker.defaultOptions = {
  		message		:	'Ticker Loaded',	/* Disregard */
  		next		:	null,		/* ID of next button or link */
  		previous	:	null,		/* ID of previous button or link */
  		stop		:	null,		/* ID of stop button or link */
  		start		:	null,		/* ID of start button or link */
  		row_height	:	'100px',	/* Height of each ticker row in PX. Should be uniform. */
  		speed		:	800,		/* Speed of transition animation in milliseconds */
  		interval	:	4000,		/* Time between change in milliseconds */
		max_items	: 	null, 		/* Integer for how many items to display at once. Resizes height accordingly (OPTIONAL) */
  };
  
  $.fn.totemticker = function( options ){
    return this.each(function(){
    	(new $.omr.totemticker(this, options));
  	});
  };
  
})( jQuery );