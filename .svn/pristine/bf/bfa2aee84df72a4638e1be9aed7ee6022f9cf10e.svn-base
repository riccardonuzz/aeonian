/*================================================================================
	Item Name: Materialize - Material Design Admin Template
	Version: 3.1
	Author: GeeksLabs
	Author URL: http://www.themeforest.net/user/geekslabs
================================================================================

NOTE:
------
PLACE HERE YOUR OWN JS CODES AND IF NEEDED.
WE WILL RELEASE FUTURE UPDATES SO IN ORDER TO NOT OVERWRITE YOUR CUSTOM SCRIPT IT'S BETTER LIKE THIS. */

function getDashboard(response){
	var sensorNumber=0;	

	console.log(response);

	//alert(response[0].Ambienti[0].Nome);

	//alert(response[0].Ambienti.length);
	for(var i=0; i<response[0].Ambienti.length; i++)
	{
		sensorNumber= sensorNumber + response[0].Ambienti[i].Sensori.length;
	}
		
	  
	//stampo numero impianti e numero sensori
	var content='<div class="row"><div class="col s12 m6 l3"><div class="card"><div class="card-content green white-text"><p class="card-stats-title"><i class="mdi-social-group-add"></i> Numero ambienti</p><h4 class="card-stats-number">'+response[0].Ambienti.length+'</h4></div></div></div><div class="col s12 m6 l3"> <div class="card"> <div class="card-content pink lighten-1 white-text"> <p class="card-stats-title"><i class="mdi-editor-insert-drive-file"></i> Numero sensori</p><h4 class="card-stats-number">'+sensorNumber+'</h4> </div></div></div></div></div>';
	  
	  
     for(var i=0; i<response[0].Ambienti.length; i++)
	 {
		  
	 	content=content+'<div class="section"><h4>'+response[0].Ambienti[i].Nome+'</h4><div class="divider"></div></div></div><div class="row"></div><div class="row">';
		
		 for(var k=0; k<response[0].Ambienti[i].Sensori.length; k++) {
			

			 content=content+'<div class="col s4 m4 l4"><div id="card-reveal" class="section"> <div class="row"> <div class="col s12 m12 l12"></div><div class="col s12 m12 l12"> <div class="row"> <div class="col s12 m12 l12">';


			 if(response[0].Ambienti[i].Sensori[k].UnitaMisura=="Celsius") {
				content=content+'<div class="card"> <div class="card-image waves-effect waves-block waves-light teal">';
			 }

			 else if(response[0].Ambienti[i].Sensori[k].UnitaMisura=="Percentuale") {
				content=content+'<div class="card"> <div class="card-image waves-effect waves-block waves-light indigo darken-4">';
			 }

			 else if(response[0].Ambienti[i].Sensori[k].UnitaMisura=="millibar") {
				content=content+'<div class="card"> <div class="card-image waves-effect waves-block waves-light amber">';
			 }

			 else {
				content=content+'<div class="card"> <div class="card-image waves-effect waves-block waves-light pink">';
			 }
			 
			 content=content+'<canvas id="'+response[0].Ambienti[i].Sensori[k].IDSensore+'" style="margin-top: 15px; height: 100%!important; width: 92%!important; margin-left:15px;"></canvas> </div><div class="card-content"> <span class="card-title activator grey-text text-darken-4">'+response[0].Ambienti[i].Sensori[k].Nome+'<i class="mdi-action-info-outline right"></i></span></div><div class="card-reveal"> <span class="card-title grey-text text-darken-4">'+response[0].Ambienti[i].Sensori[k].Nome+'<i class="mdi-navigation-close right"></i></span>';

			 if(response[0].Ambienti[i].Sensori[k].Min==null) {
				content=content+ '<p>Nessuna rilevazione è stata effettuata dal sensore.</p></div></div></div></div></div></div></div></div>';
			 }
			 else {
			 	content=content+ '<h5>Min: '+response[0].Ambienti[i].Sensori[k].Min+'</h5><br><h5>Max: '+response[0].Ambienti[i].Sensori[k].Max+'</h5><br><h5>Media: '+response[0].Ambienti[i].Sensori[k].Media+'</h5></div></div></div></div></div></div></div></div>';
			 }
		 }

		 content=content+'</div>';
		 

 	  }
	  
	 $("#dashboard-content").html(content);


	 for(var i=0; i<response[0].Ambienti.length; i++)
	{
			
		
		for(var k=0; k<response[0].Ambienti[i].Sensori.length; k++) {

			var dati = [];
			var labels = [];
			for(var j=0; j<response[0].Ambienti[i].Sensori[k].Rilevazioni.length; j++) {
				dati[j] = response[0].Ambienti[i].Sensori[k].Rilevazioni[j].value;
				var ore = new Date(response[0].Ambienti[i].Sensori[k].Rilevazioni[j].Data).getHours();
				var minuti = new Date(response[0].Ambienti[i].Sensori[k].Rilevazioni[j].Data).getMinutes();
				 labels[j] = ore + ":" + minuti; 
			}

			var LineChartSampleData = {
				labels: labels,
				datasets: [{
				 label: "Valori grafico",
				fillColor : "rgba(128, 222, 234, 0.6)",
				strokeColor : "#ffffff",
				pointColor : "#00bcd4",
				pointStrokeColor : "#ffffff",
				pointHighlightFill : "#ffffff",
				pointHighlightStroke : "#ffffff",
				 data: dati
				}]
			   };

			//console.log(pieData);

			// Get the context of the canvas element we want to select
			var grafico= document.getElementById(response[0].Ambienti[i].Sensori[k].IDSensore).getContext("2d");

			

			new Chart(grafico).Line(LineChartSampleData, {scaleGridLineColor : "rgba(255,255,255,0.4)", scaleFontColor: "#fff"});
			

		}

		

	}

	

}



