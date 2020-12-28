
// JavaScript Document
//************* AJAX *********************//
var isIE = false;
function getXhrReturn(){
  if(window.XMLHttpRequest) // Firefox et autres
     var newxhr = new XMLHttpRequest();
  else if(window.ActiveXObject){ // Internet Explorer
     try {
        var newxhr = new ActiveXObject("Msxml2.XMLHTTP");
		isIE = true;
      } catch (e) {
        var newxhr = new ActiveXObject("Microsoft.XMLHTTP");
    }
  }
  else { // XMLHttpRequest non supporté par le navigateur
     alert("Votre navigateur ne supporte pas les objets XMLHTTPRequest...");
     var newxhr = false;
  }
  return newxhr;
}
/*********************** FIN AJAX ************************/

function insertMs(mess, id)
{
	var lstM = document.getElementById('listMess');
	var chmpMs = document.getElementById('champMsg');
	var parurl = "func.inc.php?action=sendMs&user="+id+"&message="+mess ;
	xhrListShp = getXhrReturn() ;
	xhrListShp.onreadystatechange = function(){
		if(xhrListShp.readyState == 4 && xhrListShp.status == 200){
			var str = xhrListShp.responseText;
			arrayStr = str.split('split_content')[1];
			//alert(str);
			lstM.innerHTML = arrayStr+'<p></p>';
			lstM.scrollTop = lstM.scrollHeight;
			StartTheTimer();
		}
	}
	xhrListShp.open("GET",parurl,true);
	xhrListShp.send(null);
	chmpMs.focus();
	chmpMs.value='';
}
function loadContent(){
	var lstM = document.getElementById('listMess');
		var parurl = "func.inc.php?action=load";
		xhrListShp = getXhrReturn() ;
		xhrListShp.onreadystatechange = function(){
			if(xhrListShp.readyState == 4 && xhrListShp.status == 200){
				var str = xhrListShp.responseText;
				arrayStr = str.split('split_content')[1];
				lstM.innerHTML = arrayStr;
			}
		}
	xhrListShp.open("GET",parurl,true) ;
	xhrListShp.send(null) ;
}	
/********* timer *********/
var secs=0;
var timerID = null;
var timerRunning = true;
var delay = 800;

function InitializeTimer()
{
  secs = 3;
  StartTheTimer();
}

function StartTheTimer()
{
  if (secs==0)
  {
    secs = 10;
    loadContent();
  }
  //self.status = secs;
  secs = secs - 1;
  if (timerRunning)
  {
    timerID = self.setTimeout("StartTheTimer()", delay);
  }
}

/*******fin timer**********/
function removeUser(user)
{
	var user = document.getElementById('ps').value;
	var parurl = "func.inc.php?action=removeUser&pseudo="+user;
	xhrListShp = getXhrReturn() ;
		xhrListShp.onreadystatechange = function(){
		if(xhrListShp.readyState == 4 && xhrListShp.status == 200){
			str = xhrListShp.responseText ;
		}
	}
	xhrListShp.open("GET",parurl,true);
	xhrListShp.send(null);
}

function AddSmiley (emo)
{
	var message = document.getElementById('champMsg');
	message.value = message.value + " " + emo;
	message.focus();
}





