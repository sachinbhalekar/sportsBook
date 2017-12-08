//used by all pages to find the latitude and longitude...
function getLatLong()//to set the latitude and longitude for the address entered by user
{
    //alert('getLatLong');
    var vAddress1 = document.getElementById('address1').value.trim();
	var vAddress2 = document.getElementById('address2').value.trim();
	var vCity = document.getElementById('city').value.trim();
	var vState = document.getElementById('state').value.trim();
	var vZipcode = document.getElementById('zipcode').value.trim();
	
	var geocoder = new google.maps.Geocoder();// using google object
	var address = vAddress1+", "+vAddress2+", "+vCity+", "+vState+", "+vZipcode;
	if(vAddress1!='' && vCity!='' && vState!='' && vZipcode!='')
	{
        geocoder.geocode( { 'address': address}, function(results, status) {//Google API to find the latitude and longitude
        	if (status == 'OK') 
        	{
        		//vLat = results[0].geometry.location.lat();
        		document.getElementById('latitude').value = results[0].geometry.location.lat();
        		//vLong = results[0].geometry.location.lng();
        		document.getElementById('longitude').value = results[0].geometry.location.lng();
        		//alert(document.getElementById('longitude').value);
        	} 
        });
	}
}