//This JS is used by all modules for 'interested' button

var xmlhttp;
var vSelectedPost;
var vSelectedPostId;

//respond function for the AJAX call
function respond() 
{
	if (xmlhttp.readyState == 4 && xmlhttp.status == 200) //if processing is done and http response is OK
	{
		if(xmlhttp.responseText === 'success')
		{
			var vInterested;
			if(vSelectedPost === 'activity')
			{
				vInterested = parseInt(document.getElementById('activity_post_interested'+vSelectedPostId).innerHTML) + 1;
				document.getElementById('activity_post_interested'+vSelectedPostId).innerHTML = vInterested;
			}
			else if(vSelectedPost === 'event')
			{
				vInterested = parseInt(document.getElementById('event_post_interested'+vSelectedPostId).innerHTML) + 1;
				document.getElementById('event_post_interested'+vSelectedPostId).innerHTML = vInterested;
			}
		}
	}
}

//function to be called when user selects 'I'm interested'
function addInterested( vPost, vPostId, vUserEmail )
{
	vSelectedPost = vPost;
	vSelectedPostId = vPostId;
	
	var vObj = {
			userEmail: vUserEmail,
			postId: vPostId,
		 	post: vPost
		};
	
	var vJSONObj = JSON.stringify(vObj);
	//console.log(vJSONObj);
	
	//set XML HTTP request
	if (window.XMLHttpRequest) 
	{
		xmlhttp = new XMLHttpRequest();
	}
	else 
	{
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	xmlhttp.onreadystatechange = respond;//setting return function 
	xmlhttp.open("POST", "addInterest.php", true);//calling the php via AJAX
	xmlhttp.send(vJSONObj);//send JSON data to the called php
  
	return false;
}