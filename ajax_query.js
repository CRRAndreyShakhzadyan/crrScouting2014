//checks to see if the parameters passed in are valid
function validateParams(parameterNames, parameters){
	if(parameterNames.length!=parameters.length){
		return "ERROR parameter names and parameters are not the same length";
	}else if(parameterNames.length==0){
		return "ERROR parameters are empty";
	}
	return "";
}

//sends a GET query to the script with parameters parameters
function phpGET(script, parameterNames, parameters){
	document.write("php test");
	var valid=validateParams(parameterNames, parameters);
	if(valid!="")
		return valid;
	var result="";
	var query=script+"?";
	for(var i=0;i<parameterNames.length-1 && valid;i++){
		query=query+parameterNames[i]+"='"+parameters[i]+"'&"
	}
	query=query+parameterNames[parameters.length-1]+"='"+parameters[parameters.length-1]+"'";
	
	var xmlhttp;
	if (window.XMLHttpRequest){
		xmlhttp=new XMLHttpRequest();
	}else{
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			result=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET",query,true);
	//xmlhttp.open("GET","/php/graph.php?team=639",true);
	xmlhttp.send();
	
	return result;
}

//sends a POST query to the script with parameters parameters
function phpPOST(script, parameterNames, parameters){
	var valid=validateParams(parameterNames, parameters);
	if(valid!="")
		return valid;
	
	var result="";
	var query=script+"?";
	for(var i=0;i<parameterNames.length-1 && valid;i++){
		query=query+parameterNames[i]+"='"+parameters[i]+"'&"
	}
	query=query+parameterNames[parameters.length-1]+"='"+parameters[parameters.length-1]+"'";
	
	var xmlhttp;
	if (window.XMLHttpRequest){
		xmlhttp=new XMLHttpRequest();
	}else{
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			result=xmlhttp.responseText;
		}
	}
	
	xmlhttp.open("POST", "basicform.php", true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send(query);
	return result;
}