var map, geocoder;
var directionsRenderer, directionsService;

function maps_initialize() {
	
	var enderAte = google_maps.latitude+','+google_maps.longitude;		

	if (window.google == null)
	{
		var elem = document.getElementById('msg');
		elem.innerHTML = 'NÃƒÆ’Ã‚Â£o foi possÃƒÆ’Ã‚Â­vel exibir o mapa.<br /><b>Verifique sua conexÃƒÆ’Ã‚Â£o com a internet</b>';
	}
	else
	{
		var myOptions = {
			disableDefaultUI: true,								//Enables/disables all default UI. May be overridden individually.
			zoom: 16,												//The initial Map zoom level. Required.
			scrollwheel: false,										//If false, disables scrollwheel zooming on the map. The scrollwheel is enabled by default.
			mapTypeId: google.maps.MapTypeId.ROADMAP				//The initial Map mapTypeId. Required.
		};
		
		map = new google.maps.Map(document.getElementById('map_canvas'), myOptions);
		geocoder = new google.maps.Geocoder();

		geocoder.geocode( { 'address': enderAte, 'region' : 'BR'},trataLocs);
		
	}

}

function trataLocs (results, status) {
	var elem = document.getElementById('msg');
	
	if (status == google.maps.GeocoderStatus.OK) {

		map.setCenter(results[0].geometry.location);
		if(google_maps.image != ''){
			var marker = new google.maps.Marker({	map: map, position: results[0].geometry.location, icon: google_maps.image});  //COM IMAGEM
		}else{
			var marker = new google.maps.Marker({	map: map, position: results[0].geometry.location}); //SEM IMAGEM
		}
		if (results.length > 1) {

			var i, txt = '<select style="font-family:Verdana;font-size:8pt;width=550px;" onchange="mostraEnd(this.options[this.selectedIndex].text);">';
			elem.innerHTML = 'O endereÃƒÆ’Ã‚Â§o exato nÃƒÆ’Ã‚Â£o foi localizado - hÃƒÆ’Ã‚Â¡ ' +  results.length.toString() + ' resultados aproximados.<br />';
			
			for (i = 0; i < results.length; i++) {

				txt = txt + '<option value="' + i.toString() + '"';
				if (i == 0)	txt = txt + ' selected="selected"'; 
				txt = txt + '>' + results[i].formatted_address + '</option>';
				
			}
			txt = txt + '</select>'
			elem.innerHTML = elem.innerHTML + txt;
		}else{
			var infowindow = new google.maps.InfoWindow({
				content:'	<div class="i-box">'+
						'		<div class="i-box-title">'+
						'			<p>'+google_maps.business+'</p>'+
						'		</div>'+
						'		<div class="i-box-location"><p>'+
						'			<span class="street-address">'+google_maps.street_address+'</span></br>'+
						'			<span class="neighborhood">'+google_maps.neighborhood+ ((google_maps.neighborhood!='')?' - ':'') +google_maps.locality+ ((google_maps.locality!='')?' - ':'') +google_maps.state+'</span><br />'+
						'			<span class="country">'+google_maps.country+ ((google_maps.country!='')?' - ':'') +google_maps.zip+'</span><br />'+						
						'		</p></div>'+
						'		<div class="i-box-more">'+
						'			<a target="_blank" href="https://www.google.com/maps?ll='+google_maps.latitude+','+google_maps.longitude+'&z=16&t=m&hl=pt-BR&gl=US&mapclient=apiv3">Ampliar mapa</a>'+
						'		</div>'+
						'	</div>'
							
			});
				
			google.maps.event.addListener(marker, 'click', function() {
			  infowindow.open(map,marker);
			});
		}
	} else {
		alert('Erro no tratamento do endereÃƒÆ’Ã‚Â§o');
	}
	
}
function mostraEnd(selectEnd){
	geocoder.geocode( { 'address': selectEnd, 'region' : 'BR'},trataLocs);
}