var isIE = false;
function getXhrReturn(){if(window.XMLHttpRequest)var newxhr = new XMLHttpRequest();
else if(window.ActiveXObject){try{var newxhr=new ActiveXObject("Msxml2.XMLHTTP");sIE = true;}
catch (e){var newxhr = new ActiveXObject("Microsoft.XMLHTTP");}}else{alert("Votre navigateur ne supporte pas les objets XMLHTTPRequest...");var newxhr = false;}return newxhr;}

function checkPseudo(psd)
{
	if(psd == "")
	{
		document.getElementById('frm_fandraisana').action='fandraisana.php';
		return;
	}
	insertUser(psd);
	document.getElementById('frm_fandraisana').action='resaka.php';
	return;
}

function insertUser(user)
{
	var parurl = "func.inc.php?action=insertUser&pseudo="+user;
	var str='';
	xhrListShp = getXhrReturn();
	xhrListShp.onreadystatechange = function(){
		if(xhrListShp.readyState == 4 && xhrListShp.status == 200){
			str=xhrListShp.responseText;
		}
	}
	xhrListShp.open("POST",parurl,true);
	xhrListShp.send(null);
	return str;
}

function loadfile(file, elem)
{
	var idElem = document.getElementById(elem)
	var parurl = file;
	idElem.innerHTML="<center><img src='img/ramiLoad.gif' alt='Loading ...' class='loading'></img></center>";
	xhrListShp = getXhrReturn();
	xhrListShp.onreadystatechange = function(){
		if(xhrListShp.readyState == 4 && xhrListShp.status == 200){
			str = xhrListShp.responseText;
			var tbStr = str.split('\n');
			var newStr = "";
			for (i=0; i<tbStr.length; i++)
			{
				newStr = newStr+tbStr[i]+"<br>";
			}
			idElem.innerHTML=newStr;
		}
	}
	xhrListShp.open("POST",parurl,true);
	xhrListShp.send(null);
}

function loadPhp(file, elem)
{
	var idElem = document.getElementById(elem);
	var parurl = file;
	xhrListShp = getXhrReturn();
	xhrListShp.onreadystatechange = function(){
		idElem.innerHTML="<center><img src='img/ramiLoad.gif' alt='Loading ...' class='loading'></img></center>";
		if(xhrListShp.readyState == 4 && xhrListShp.status == 200){
			str = xhrListShp.responseText;
			//alert(str);
			//arrayStr = str.split('split_content')[1];
			idElem.innerHTML=str;
			str="";
		}
	}
	xhrListShp.open("POST",parurl,true);
	xhrListShp.send(null);
	//xhrListShp = "";
}

function showImg(img, elem)
{
	var fenetre = document.getElementById(elem);
	fenetre.innerHTML="<img src="+img+" alt ='tof'>";
}

function hideImg(elem)
{
	document.getElementById(elem).innerHTML="";
}