function isNumberKey(evt)
{
    var charCode = (evt.which) ? evt.which : event.keyCode;
   
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    else
    	return true;
}

function isMoneyKey(evt,val)
{
    var charCode = (evt.which) ? evt.which : event.keyCode;
   
    if(charCode == 46)
    {
    	 if(val.indexOf(".") === -1)
    	 	return true;
    	 else
    	 	return false;
    	 	
    }
    else if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    else
    	return true;
}


var validate = function(evt) 
{
  var t = evt.value;
  evt.value = (t.indexOf(".") >= 0) ? (t.substr(0, t.indexOf(".")) + t.substr(t.indexOf("."), 3)) : t;
}


function GViframeDirect(src)
{
   parent.document.getElementById("GVmainFrame").src = src;
}

function GVformPost()
{
  $("#GVform"). submit();
}

function GVloadDirect(src)
{
    parent.location.href = src;
}

function GVtopDirect(src)
{
    top.location.href = src;
}

function GVcallLoader()
{
	var OutDiv =  parent.document.getElementById("GVLOADEROUT");
	
	if(OutDiv)
	{
		var _body = parent.document.body;
		var _html = parent.document.documentElement;

		var _width = Math.max(_body.scrollWidth,_html.scrollWidth,_html.clientWidth,_body.offsetWidth,_html.offsetWidth);
		var _height = Math.max(_body.scrollHeight,_html.scrollHeight,_html.clientHeight,_body.offsetHeight,_html.offsetHeight,_html.clientHeight);
		
		OutDiv.style.width = _width;
		OutDiv.style.height = _height;
		
		OutDiv.style.left =  "0px";
		OutDiv.style.top =  "0px";
		OutDiv.style.overflow = "hidden";
		OutDiv.style.display = "block";
		OutDiv.style.position = "absolute";
		
		var InDiv =  parent.document.getElementById("GVLOADERIN");
		
		var _left =(screen.width / 2) - 25;
		var _top = (screen.height / 2) - 120;
		
		InDiv.style.width = "50px";
		InDiv.style.height = "50px";
		InDiv.style.left = _left + "px";
		InDiv.style.top = _top + "px";
		InDiv.style.position = "absolute";
		return false;
	}
}

function GVpopupCall(popSrc, width, height)
{
	var OutDiv =  parent.document.getElementById("GVPOPOUT");
	GVcallLoader();
	
	if(OutDiv)
	{
		var _body = parent.document.body;
		var _html = parent.document.documentElement;

		var _width = Math.max(_body.scrollWidth,_html.scrollWidth,_html.clientWidth,_body.offsetWidth,_html.offsetWidth);
		var _height = Math.max(_body.scrollHeight,_html.scrollHeight,_html.clientHeight,_body.offsetHeight,_html.offsetHeight,_html.clientHeight);
		
		OutDiv.style.width = _width;
		OutDiv.style.height = _height;
		
		OutDiv.style.left =  "0px";
		OutDiv.style.top =  "0px";
		OutDiv.style.overflow = "hidden";
		OutDiv.style.display = "block";
		OutDiv.style.position = "absolute";
		
		var InDiv =  parent.document.getElementById("GVPOPIN");
		
		var _left =(screen.width / 2) - (width / 2);
		var _top = (screen.height / 2) - (height / 2) - 100;
		
		InDiv.style.width = width;
		InDiv.style.height = height;
		InDiv.style.left = _left + "px";
		InDiv.style.top = _top + "px";
		InDiv.style.position = "absolute";
		
		var GVpopFrame =  parent.document.getElementById("GVPopFrame");
		InDiv.style.width = width;
		InDiv.style.height = height;
		GVpopFrame.src = popSrc;
		return false;
	}
}

function GVStopLoader()
{
	parent.document.getElementById("GVLOADEROUT").style.display = "none";
}

function GVClosePopup()
{
	if(parent.document.getElementById("GVPopFrame"))
		parent.document.getElementById("GVPopFrame").src = "";
		
	if(parent.document.getElementById("GVPOPOUT"))
		parent.document.getElementById("GVPOPOUT").style.display = "none";
}

function GVSortMethodClick(_txtSortName, _txtSortMethod)
{
	$("#txtSortName").val(_txtSortName);
	$("#txtSortMethod").val(_txtSortMethod);
	GVformPost();
}


function GVformSubmitCall(_methodVal)
{
	$("#hiddenPostMethod").val(_methodVal);
	GVcallLoader();
	$("#GVform"). submit();
}

function setGVPageSession(_recordSSData,_SSDataKey, _LoadType=0)
{
	$.ajax({
		url: "../backend/gv_session_set",
		type: "POST",
		data:{recordSSData: _recordSSData,GVAjaxAction:_SSDataKey},
		cache:false,
		success: function (response) 
		{
			response = response.trim();
			
			if(response.indexOf("[GVT]") !== -1)
			{
				var pos = response.indexOf("[GVT]");
				response = response.substr(pos+5);
				response = JSON.parse(response);
				
				if(response["STATUS"] == "EXPIRED")
				{
					GVStopLoader();
					GVtopDirect("../backend/redirect");  
				}
				else if(response["STATUS"] == "SUCCESS")
				{
					if(_LoadType == 2)
						GVClosePopup();
					else if(_LoadType == 1)
						GViframeDirect("../backend/gv_page_redirect");
					else	
						GVtopDirect("../backend/redirect");
				}
				else
				{
					if(_LoadType != 2)
						GVStopLoader();
				}
			}
		},
		Error: function(xhr, status, error) {
			
			if(_LoadType != 2)
			GVStopLoader();
		}
	});
}

function setGVPopupSession(_recordSSData,_SSDataKey,_width,_height)
{
	$.ajax({
		url: "../backend/gv_session_set",
		type: "POST",
		data:{recordSSData: _recordSSData,GVAjaxAction:_SSDataKey},
		cache:false,
		success: function (response) 
		{
			response = response.trim();
			
			if(response.indexOf("[GVT]") !== -1)
			{
				var pos = response.indexOf("[GVT]");
				response = response.substr(pos+5);
				response = JSON.parse(response);
				
				if(response["STATUS"] == "SUCCESS")
				{
					GVpopupCall("../backend/gv_page_redirect",_width,_height);
				}
				else
				{
					GVStopLoader();
				}
			}
		},
		Error: function(xhr, status, error) {
			GVStopLoader();
		}
	});
}