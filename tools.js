// JavaScript Document
var currentdoc=null;
var ajaxObject=function(){
           
        this.createRequestObject=function() {
                var tmpXmlHttpObject;
             
                //depending on what the browser supports, use the right way to create the XMLHttpRequest object
                if (window.XMLHttpRequest) {
                    // Mozilla, Safari would use this method ...
                    tmpXmlHttpObject = new XMLHttpRequest();
                   
                } else if (window.ActiveXObject) {
                // IE would use this method ...
                tmpXmlHttpObject = new ActiveXObject("Microsoft.XMLHTTP");
            }
            return tmpXmlHttpObject;
        };
        var http=this.createRequestObject();
		/**
		dual login
		*/
		
		this.dualLogin=function(url){
			http.open('get',url);
			
            //assign a handler for the response
            http.onreadystatechange = this.dualLoginRs;   
            //actually send the request to the server
            http.send(null);
		}
		this.dualLoginRs=function(){
			 if(http.readyState == 4){
          		var response = http.responseText;
				callSubmit();
			 }else{
			 }
		}
		/***
			get music
		*/
		this.httGetMusic=function(url){
            http.open('get',url);
            //assign a handler for the response
            http.onreadystatechange = this.showMusic;   
            //actually send the request to the server
            http.send(null);

		};
		this.showMusic=function(){
		 if(http.readyState == 4){
          	var response = http.responseText;
		 	obj=eval("("+response+")");
			for(i=0;i<obj.length;i++){
				item=obj[i];
				
			}
			showMusicBox(obj);
       	   }else{
			// document.getElementById("progress-load").style.display='block';
		  }
		}
		this.httpPreviewFlashCard=function(url){
			//make a connection to the server ... specifying that you intend to make a GET request
            //to the server. Specifiy the page name and the URL parameters to send
            http.open('get',url);
            //assign a handler for the response
            http.onreadystatechange = this.getCardCode;   
            //actually send the request to the server
            http.send(null);
		}
		this.getCardCode=function(){
			if(http.readyState == 4){
           	var response = http.responseText;
		 	//	alert(response);
 
			start=response.indexOf("<object");
			end=response.indexOf("</body>");

			x_flashcard1=response.substring(start,end);
			document.getElementById('flashcard').innerHTML=x_flashcard1;
			showid2('div_card_body','block');
			showid2("show_edit_sendnow_toolbar_top","block");
			showid2("show_edit_sendnow_toolbar_bottom","block");

			showid2('show_personalize_table','none');		
			showid2('show_change_next_step_fav_toolbar','none');
			showid2("show_option_toolbar","none");
			showid2("show_change_next_step_fav_toolbar","none");

       	   }else{
		//	 document.getElementById("progress-load").style.display='block';
		   }
		}
		this.httpPreviewCard=function (url){
		   //make a connection to the server ... specifying that you intend to make a GET request
            //to the server. Specifiy the page name and the URL parameters to send
            http.open('get',url);
            //assign a handler for the response
            http.onreadystatechange = this.previewCard;   
            //actually send the request to the server
            http.send(null);
		}
		this.previewCard=function(){
		 if(http.readyState == 4){
           	 var response = http.responseText;
		 	//	alert(response);
 
			start=response.indexOf("<object");
			end=response.indexOf("</body>");

			x_flashcard1=response.substring(start,end);
			document.getElementById('cardcontent').innerHTML=x_flashcard1;
			//centerdiv(1000,1000,'ui-dialog-overlay');		
			centerdiv(500,500,'flashcard1');
		   // document.getElementById("progress-load").style.display='none';
       	   }else{
		//	 document.getElementById("progress-load").style.display='block';
		  }
		}
		this.httpGetData=function(url){
			   //make a connection to the server ... specifying that you intend to make a GET request
            //to the server. Specifiy the page name and the URL parameters to send
        
            http.open('get',url);
            //assign a handler for the response
            http.onreadystatechange = this.returnXMLData;   
            //actually send the request to the server
            http.send(null);
		}
	 this.returnXMLData=function(){
        if(http.readyState == 4){
            var response = http.responseText;
			obj=eval("("+response+")");
			cols=obj[0];
			html=showComments(obj[1]);
			page=obj[2];
			links=pagerUtil.get_page_links(page,Math.ceil(cols/5));
			
		//	alert(html);
			document.getElementById("comment_list").innerHTML=html;
			document.getElementById("comment_page").innerHTML=links;
		    document.getElementById("show_loading").style.display='none';
        }else{
			document.getElementById("show_loading").style.display='block';
		}

	}
	this.httpGetDetail=function(url){
			   //make a connection to the server ... specifying that you intend to make a GET request
            //to the server. Specifiy the page name and the URL parameters to send
        
            http.open('get',url);
            //assign a handler for the response
            http.onreadystatechange = this.returnDetailJsonData;   
            //actually send the request to the server
            http.send(null);
		}
	this.returnDetailJsonData=function(){
        if(http.readyState == 4){
            var response = http.responseText;
            obj=eval("("+response+")");
			alert(obj.length);
			//detailp=new floatPopup();
			//detailp.init(0,0,true,"Charity Detail","Hello",100,100,true);
   			 //detailp.display();
		 //  showCharitesList(obj);
		  //document.getElementById("progress-load").style.display='none';
        }else{
			//document.getElementById("progress-load").style.display='block';
		}

	}
	
};

function showComments(obj){
	var html="";
	html+="<ul class=\"user_comment\">";
	for(i=0;i<obj.length;i++){
		item=obj[i];
		if (cf_show_date_option=="0") {// MM/DD/YYYY
			comment_sent_date = item.com_month+"/"+item.com_day+"/"+item.com_year;
		}
		else if (cf_show_date_option=="1") {// DD/MM/YYYY
			comment_sent_date = item.com_day+"/"+item.com_month+"/"+item.com_year;
		}
		else if (cf_show_date_option=="2") {// YYYY/DD/MM
			comment_sent_date = item.com_year+"/"+item.com_day+"/"+item.com_month;
		}
		else {// YYYY/MM/DD
			comment_sent_date = item.com_year+"/"+item.com_month+"/"+item.com_day;
		}
		html+="<li><div class=\"comment_author\">";
		html+="<strong>"+item.com_author_name+"</strong> "+message_on+" <span>"+comment_sent_date+"</span></div>";
		html+=item.com_message;
		html+="</li>";
	}
	html+="</ul>";
	document.user_comment.com_message.value="";
	return html;
}

goToPage=function(page){
	ec_id=document.user_comment.ec_id.value;
	url=root_url+"/index.php?step=add_new_comment&comment="+''+"&ec_id="+ec_id+"&page="+page;
	jax=new ajaxObject();
	jax.httpGetData(url);
	
	
}
function centerdiv(Xwidth,Yheight,divid) {
// First, determine how much the visitor has scrolled
var scrolledX, scrolledY;
if( self.pageYOffset ) {
scrolledX = self.pageXOffset;
scrolledY = self.pageYOffset;
} else if( document.documentElement && document.documentElement.scrollTop ) {
scrolledX = document.documentElement.scrollLeft;
scrolledY = document.documentElement.scrollTop;
} else if( document.body ) {
scrolledX = document.body.scrollLeft;
scrolledY = document.body.scrollTop;
}

// Next, determine the coordinates of the center of browser's window

var centerX, centerY;
if( self.innerHeight ) {
centerX = self.innerWidth;
centerY = self.innerHeight;
} else if( document.documentElement && document.documentElement.clientHeight ) {
centerX = document.documentElement.clientWidth;
centerY = document.documentElement.clientHeight;
} else if( document.body ) {
centerX = document.body.clientWidth;
centerY = document.body.clientHeight;
}

// Xwidth is the width of the div, Yheight is the height of the
// div passed as arguments to the function:
var leftOffset = scrolledX + (centerX - Xwidth) / 2;
var topOffset = scrolledY + (centerY - Yheight) / 2;
// The initial width and height of the div can be set in the
// style sheet with display:none; divid is passed as an argument to // the function
var o=document.getElementById(divid);
var r=o.style;
r.position='absolute';
r.top = topOffset + 'px';
r.left = leftOffset + 'px';
r.display = "block";
} 
var xmlUtil={
	load:function(xml){
		if(window.ActiveXObject){
		  xmlDoc=new ActiveXObject("Microsoft.XMLDOM");
  		  xmlDoc.async="false";
		  xmlDoc.loadXML(xml);
		  return xmlDoc;
		}else{
		  parser=new DOMParser();
          xmlDoc=parser.parseFromString(xml,"text/xml");
		  return xmlDoc;
		}
	}
};
var pagerUtil={
	get_page_links:function(page,b){
		count_number='<ul id="paging">';
		if(b>1){
		y=0;
		if (b <10){
			for(a_num=1; a_num<=b; a_num++) {
				y++;
				if (a_num == page) {
					count_number +="<li><span style=\"cursor: default;\" class='page_active'>"+a_num+"</span></li>";					
				}
				else {
					count_number +="<li><a class=\"page_other\" href=\"javascript:goToPage("+a_num+")\">"+a_num+"</a></li>";
				}
			}
		}else if((page > 3) && (page < (b-3))){
			for(a_num=1; a_num<=3; a_num++) {
				y++;
				count_number +="<li><a class=\"page_other\" href=\"javascript:goToPage("+a_num+")\">"+a_num+"</a></li>";
			}
			count_number +="...";
			for(a_num = page-1; a_num<=page+1; a_num++) {
				y++;
				if (a_num == page) {
					count_number +="<li><span style=\"cursor: default;\" class='page_active'>"+a_num+"</span></li>";
				}
				else {		
					count_number +="<li><a class=\"page_other\" href=\"javascript:goToPage("+a_num+")\">"+a_num+"</a></li>";
				}
			}
			count_number +="...";
			for(a_num = b-2; a_num<=b; a_num++) {
				y++;
				count_number +="<li><a class=\"page_other\" href=\"javascript:goToPage("+a_num+")\">"+a_num+"</a></li>";
			}
		}
		else{
			for(a_num=1; a_num<=4; a_num++) {
				y++;
				if (a_num == page) {
					count_number +="<li><span style=\"cursor: default;\" class='page_active'>"+a_num+"</span></li>";
				}
				else {
					count_number +="<li><a class=\"page_other\" href=\"javascript:goToPage("+a_num+")\">"+a_num+"</a></li>";
				}
			}
			count_number +="...";			
			for(a_num=b-3; a_num<=b; a_num++) {
				y++;
				if (a_num == page) {
					count_number +="<li><span style=\"cursor: default;\" class='page_active'>"+a_num+"</span></li>";
				}
				else {	
					count_number +="<li><a class=\"page_other\" href=\"javascript:goToPage("+a_num+")\">"+a_num+"</a></li>";
				}
			}
		}
		}
		return count_number+="</ul>";
	}
};
function showMusicBox(data){
		if(parent.document.getElementById('music-box')!=null){
				obj=parent.document.getElementById('music-box');
				p=obj.parentNode;
				p.innerHTML='';
		}
			html="<div id=\"music-box'\" class=\"overlay_id1\" style='width:180px'>";
				html+="<div class='pop-header1'>";
				html+="<div class='pop-header-title'>";
				//html+=this.title;
				html+="</div>";
				html+="<div class='pop-header-icon'>";
				html+="<img src='icon/icon_button_close.gif' onclick=''/>";
				html+="</div>"
				html+="</div>";

			html+="	<div class=\"game-box-float\" tabindex=\"1000\">";
			html+="music box";
			html+="</div>";
			html+="</div>";
			/*
			if(this.overlay){
				html+="<div class=\"ui-dialog-overlay\" id=\""+this.ui_dialog_id+"\"/>";
				html+="</div>";
			}
			*/
			var div=parent.document.createElement('div');
			div.innerHTML=html;
			
			parent.document.getElementsByTagName("body")[0].appendChild(div);
		//}else{
		//	document.getElementById(this.overlay_id).style.display='block';
		//	document.getElementById(this.ui_dialog_id).style.display='block';
		//}
	
		var winwidth= parent.document.body.clientWidth;
		var winheight = parent.document.body.clientHeight;
		
		//document.getElementById(this.ui_dialog_id).style.width=this.pwidth+'px';
		//document.getElementById(this.ui_dialog_id).style.height=this.pheight+'px';
		
		gameLayer=parent.document.getElementById('music-box');
		var layerheight = gameLayer.clientHeight;
		var layerwidth = gameLayer.clientWidth;
		gameLayer.style.left =0;//Math.round((winwidth - layerwidth)/2)+170 + "px";
		gameLayer.style.top = 0;//Math.round((winheight - layerheight)/2) + "px";
}
function getPoem(id){
		if(document.getElementById(id).style.display=='none'){
			document.getElementById(id).style.display='block';
		}else{
			document.getElementById(id).style.display='none';
		}
	}