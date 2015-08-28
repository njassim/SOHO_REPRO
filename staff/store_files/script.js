/*var TINY={};

function T$(i){return document.getElementById(i)}
function T$$(e,p){return p.getElementsByTagName(e)}

TINY.accordion=function(){
	function slider(n){this.n=n; this.a=[]}
	slider.prototype.init=function(t,e,m,o,k){
		var a=T$(t), i=s=0, n=a.childNodes, l=n.length; this.s=k||0; this.m=m||0;
		for(i;i<l;i++){
			var v=n[i];
			if(v.nodeType!=3){
				this.a[s]={}; this.a[s].h=h=T$$(e,v)[0]; this.a[s].c=c=T$$('div',v)[0]; h.onclick=new Function(this.n+'.pr(0,'+s+')');
				if(o==s){h.className=this.s; c.style.height='auto'; c.d=1}else{c.style.height=0; c.d=-1} s++
			}
		}
		this.l=s
	};
	slider.prototype.pr=function(f,d){
		for(var i=0;i<this.l;i++){
			var h=this.a[i].h, c=this.a[i].c, k=c.style.height; k=k=='auto'?1:parseInt(k); clearInterval(c.t);
			if((k!=1&&c.d==-1)&&(f==1||i==d)){
				c.style.height=''; c.m=c.offsetHeight; c.style.height=k+'px'; c.d=1; h.className=this.s; su(c,1)
			}else if(k>0&&(f==-1||this.m||i==d)){
				c.d=-1; h.className=''; su(c,-1)
			}
		}
	};
	function su(c){c.t=setInterval(function(){sl(c)},20)};
	function sl(c){
		var h=c.offsetHeight, d=c.d==1?c.m-h:h; c.style.height=h+(Math.ceil(d/5)*c.d)+'px';
		c.style.opacity=h/c.m; c.style.filter='alpha(opacity='+h*100/c.m+')';
		if((c.d==1&&h>=c.m)||(c.d!=1&&h==1)){if(c.d==1){c.style.height='auto'} clearInterval(c.t)}
	};
	return{slider:slider}
}();*/

$(document).ready(function () {
    $('#acc li').each(function(index, data) {
        $(data).children('div').hide();
    })   
    $('#acc h3 ,#acc h2').click(function() {
	//console.log( $(this).parent());
	
	
        var display = $(this).parent().children('.acc-section');
        if(display.css('display') == 'none') { 
            if($(this).find('.headerTotal')) {
                $(this).find('.headerTotal').remove();
                $(this).removeAttr('sectotal');
                $(this).removeAttr('cattotal');
		
                //alert($(this));
                //console.log($(this).parent().children('.acc-section'));
		//$(this).parent().children('.acc-section').hide();
		//$(this).next.toggle();
                //console.log($(this).find('h3'));
                //console.log($(this).siblings().children().children().children().filter(':first').children('h3'));
                //console.log($(this).siblings('h2').children().children());
                if($(this)[0].tagName == 'H2') {
		    //console.log($(this).children().children());
		    
		    $('#acc h2').css('color','#C4C4C4');
		    $('ul.acc> li>h2>div#line').removeClass('rbottomline');
		    $('ul.acc> li>h2>div#line').addClass('bottomline');
		    $('ul.acc> li>h2>div>img').attr('src','store_files/r1.png');
		    //console.log($(this).children('div.eachlistfullTotal'));
		    $('ul.acc> li>h2>div.eachlistfullTotal').css('color','#C4C4C4');
                    $('ul.acc> li').children('.acc-section').children('.acc-content').children('div#to_tal').children('div.sectionTotal').children('div.coline').remove();
		    //$(this).parent().parent().children().filter(':last').children('div.acc-section').children('div.acc-content').children('div#to_tal').children('div.sectionTotal').children('div.coline').remove();
		    //console.log($('ul.acc> li> div.acc-section:visible').siblings('h2').children('#title_name').children('h2').text());
		   // console.log($('ul.acc> li> div.acc-section:visible').children('div.acc-content').children().children());
		   
		   
		   
		   
		   /* h2 calculation-st*/
		   /*
		   var total=0;
		    $('ul.acc> li> div.acc-section:visible').children('div.acc-content').children().children().each(function(key,value){
			//console.log($(value).children('h3').children('.eachlistTotal').text());
			var str = $(value).children('h3').children('.eachlistTotal').attr('sectotal');
			total = parseFloat(total) + parseFloat(str);
			//console.log(total);
		    });
		    //console.log(total);
		    //console.log($('ul.acc> li> div.acc-section:visible').siblings('h2').children('div.eachlistfullTotal'));	  
		    setTimeout(function(){
			$('ul.acc> li> div.acc-section:visible').siblings('h2').children('div.eachlistfullTotal').html(total);
		    },3000);
		    */ //17 may
		    
		    /* h2 calculation-end*/
		    
		    
		    
		    
		    
		    //$('ul.acc> li> div.acc-section:visible').siblings('h2').children('div.eachlistfullTotal').html(total);
		    //$('ul.acc> li> div.acc-section:visible').siblings('h2').children('div.eachlistfullTotal').attr('catotal','0');
	            $('ul.acc> li>div').hide();	
                    //$(this).children().children().attr('src','/public/images/d1.png');
                    $(this).siblings('h2').children().children().attr('src','/sohorepro/store_files/d1.png');
                    $(this).children().children().css('color','#FF7E00');
                    $(this).parent().siblings().filter(':first').children('h2').css('padding-top','10px');
                    //$(this).children('.bottomline').css({'background': 'url("/public/images/boline.png") repeat','height':'6px'});
                    $(this).children('div').removeClass('bottomline');
                    $(this).children('#line').addClass('rbottomline');
		    $(this).children('div.eachlistfullTotal').css('color','#FF7E00');
                    //$(this).children('.bottomline').css('border','1px solid #F9E7B2');
                    //$(this).siblings().children().children().children().filter(':last').children('h3').css('border-bottom','');
                    $(this).siblings().children().children().children().filter(':last').children('h3').children('div.oline').css({'background': 'url("/public/images/boline.png") repeat','height':'6px','margin':'10px 0 -12px -6px','width':'739px'});
		    //console.log( $(this).siblings().children().children().children());
		    
                }
                if($(this)[0].tagName == 'H3') {
		    //console.log( $(this).parent().parent().parent().parent().parent().find());
		    //console.log( $(this).children().find('.eachlistTotal').val());
		    $('ul.acc> li>div.acc-section>div.acc-content>ul.acc>li>h3>div>img').attr('src','/store_files/r2.png');
		    $('ul.acc> li>div.acc-section>div.acc-content>ul.acc>li>div').hide();
                    $(this).children().children().attr('src','/store_files/d2.png');
                    $(this).find('h3').css('padding-top','5px');
		    //console.log( $(this).children().children('h3'));
		    
		    //$(this).siblings().children().children().children().filter(':last').children('h3').children('div.oline').css({'display':'none'});
                    //$(this).css('margin-top','5px');
                    //$(this).children().children().css('color','#FF7E00');
		   // console.log($(this).parent().parent().children().filter(':last')); //'li:last-child'
		  //$(this).parent().parent().children().filter(':last').css('backgroung','');
		 /* if( $(this).parent().parent().children().filter(':last') ){
		      alert('ff');
		  }*/
		   //console.log($(this).parent().parent().children().filter(':last').children('div.acc-section').children('div.acc-content').children('div#to_tal').children('div.sectionTotal'));
		   if($(this).parent().is(":last-child")){
		      $(this).parent().parent().children().filter(':last').children('h3').children('div.oline').css('background','none');
		      $(this).parent().parent().children().filter(':last').children('div.acc-section').children('div.acc-content').children('div#to_tal').children('div.sectionTotal').append('<div class="coline"></div>');
                      //$(this).parent().parent().children().filter(':last').children('div.acc-section').children('div.acc-content').children('div#to_tal').children('div.sectionTotal').css('border-bottom-image','url("/public/images/boline.png") 27 27 27 27 stretch stretch');
		   } else {
		      $(this).parent().parent().children().filter(':last').children('h3').children('div.oline').css('background','url("/public/images/boline.png") repeat scroll 0 0 transparent');
                      //console.log($(this).parent().parent().children().filter(':last').children('div.acc-section').children('div.acc-content').children('div#to_tal').children('div.sectionTotal'));
		   }    
		  
		  
                }
            }
            display.show(); 
        } else {
                if($(this)[0].tagName == 'H2') {
                    //$(this).children().children().attr('src','/public/images/r1.png');
                    $(this).siblings('h2').children().children().attr('src','store_files/r1.png');
                    $(this).children().children().css('color','#C4C4C4');
                    $(this).children('div').removeClass('rbottomline');
                    $(this).children('#line').addClass('bottomline');
		    $(this).children('div.eachlistfullTotal').css('color','#C4C4C4');
                }
                if($(this)[0].tagName == 'H3') {
                    $(this).children().children().attr('src','store_files/r2.png');
                    $(this).find('h3').css('padding-top','0px');
                    //$(this).children().children().css('color','#FF7E00');
		    $(this).parent().parent().children().filter(':last').children('h3').children('div.oline').css('background','url("/public/images/boline.png") repeat scroll 0 0 transparent');
                    if($(this).parent().is(":last-child")){
		      //$(this).parent().parent().children().filter(':last').children('h3').children('div.oline').css('background','none');
		      $(this).parent().parent().children().filter(':last').children('div.acc-section').children('div.acc-content').children('div#to_tal').children('div.sectionTotal').children('div.coline').remove();
                      //$(this).parent().parent().children().filter(':last').children('div.acc-section').children('div.acc-content').children('div#to_tal').children('div.sectionTotal').css('border-bottom-image','url("/public/images/boline.png") 27 27 27 27 stretch stretch');
		   }
                }
            //console.log($(this).dren());
            //console.log(display.find('.acc-content .sectionTotal').attr());
            
            if(display.children().find('h3').length == 0) {
                if(display.find('.acc-content .sectionTotal').attr('calculated')) {
                    var stotal = display.find('.acc-content .sectionTotal').attr('calculated');
                    //$(this).append('<div class="headerTotal" style="float:right;margin-top:-12px;" sectotal="'+ stotal +'"> $' + stotal + '</div>');
                    //$(this).attr('sectotal', stotal);
                }
            } else {
                var stotal = 0;
                display.children().find('h3').each(function(inx, ddtat) {
                    if($(ddtat).attr('sectotal')) {
                        stotal = stotal + parseFloat($(ddtat).attr('sectotal'));                      
                    }
                });
		if(stotal.toFixed(2) != 0.00) {
		   // $(this).append('<div class="headerTotal" style="float:right;font-size:18px;font-weight:bold;color:#5C5C5C;margin-top:-28px;" cattotal="'+ stotal.toFixed(2) +'"> $' + stotal.toFixed(2) + '</div>');
		    
		   // $(this).attr('cattotal', stotal.toFixed(2));
		   console.log(display);
	        }
            }
            display.hide();
            
        }
    });
    $('.proquan').change(function () {
        var newtotal=document.getElementById('allCurrentOrderTotal').innerHTML;
        var split_newtotal=newtotal.split('$');
        var total = $(this).val() * $(this).attr('price');
        var totalWapper = $(this).parent().parent().children().get(4);
        $(totalWapper).html(total.toFixed(2));
        $(totalWapper).attr('calculated', total.toFixed(2));
        var subtotal = 0;
        $(this).parents('table').children().find('.proquan').each(function(key, element) {
            if($(element).val()) {
                subtotal = subtotal + (parseFloat($(element).val()) * $(element).attr('price'));
            }
        });
    
        var newtotals=0;
        $('.proquan').each(function() {
       //console.log( $(this).val() );
            if($(this).val()!='')
            {
                newtotals= parseFloat(newtotals) + parseFloat($(this).val() * $(this).attr('price'));
            }
        })
        
        
        //alert(newtotals);
        //alert(subtotal);
        $(this).parents('table').parent().find('.sectionTotal strong').html('$' + subtotal.toFixed(2));
        $(this).parents('table').parent().find('.sectionTotal').attr('calculated', subtotal.toFixed(2));
	//console.log($(this).parent().parent().parent().parent().siblings().find('.sectionTotal').children().find('label#s_total').text());
	//console.log($(this).parents('table').parent().find('.sectionTotal').find('#s_total').value);
	$(this).parents('table').parent().find('.sectionTotal').find('#s_total').html('$' + subtotal.toFixed(2));
	//$(this).parent().parent().parent().parent().siblings().find('.sectionTotal').children().find('span#s_total').text();
        var total = 0;
        $(this).parents('#acc').find('.proquan').each(function(key, element) {
            if($(element).val()) {
                //alert(parseInt($(element).val()));
                total = total + (parseFloat($(element).val()) * $(element).attr('price'));
            }
        });
    
        //total = parseInt(total.toFixed(2))+parseInt(split_newtotal[1]);
        total = newtotals;
        
        $('#allCurrentOrderTotal').html('$' + total.toFixed(2));
        $('#allCurrentOrderTotal1').html('$' + total.toFixed(2));
	//console.log($(this).parents('table').parent().parent().parent().children('h3').children('.eachlistTotal').text());
	$(this).parents('table').parent().parent().parent().children('h3').children('.eachlistTotal').html('$' + subtotal.toFixed(2));
	$(this).parents('table').parent().parent().parent().children('h3').children('.eachlistTotal').attr('sectotal', subtotal.toFixed(2));
	
	
	
	///////////////////outer h2
	
	//console.log($(this).parents('table').parent().parent().parent().parent().children());
	var total=0;
	$(this).parents('table').parent().parent().parent().parent().children().each(function(key,value){
	    //console.log($(value).children('h3').children('.eachlistTotal').attr('sectotal'));
	    var str = $(value).children('h3').children('.eachlistTotal').attr('sectotal');
	    //console.log(str);
	    if(str !== "") {
		total = parseFloat(total) + parseFloat(str);
		
	    }
	    
	});
	
	//console.log($(this).parents('table').parent().parent().parent().parent().parent().parent().siblings('h2').children('div.eachlistfullTotal'));
	
	$(this).parents('table').parent().parent().parent().parent().parent().parent().siblings('h2').children('div.eachlistfullTotal').html('$'+total.toFixed(2));
	$(this).parents('table').parent().parent().parent().parent().parent().parent().siblings('h2').children('div.eachlistfullTotal').attr('catotal',total.toFixed(2));
	/* setTimeout(function(){
             $(this).parents('table').parent().parent().parent().parent().parent().parent().siblings('h2').children('div.eachlistfullTotal').html('$'+total);
 
        },100);*/
	
	/*end*/
    });

    $('.addstroeproductActionLink').click(function() {
        //alert('I was clicked');
        $('#supplystoreform').submit();
    });

});