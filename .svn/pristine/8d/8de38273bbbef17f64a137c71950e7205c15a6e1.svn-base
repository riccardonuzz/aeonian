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
	
	response = JSON.parse(response.replace(/&quot;/g,'"'));
	console.log(response);
	var sensorNumber=0;	

	/* ABILITARE IN CASO DI DEBUG */
	//console.log(response);

	//alert(response[0].Ambienti[0].Nome);
	
	var ambienti = response[0].Ambienti;
	
	
	//alert(response[0].Ambienti.length);
	for(var i = 0; i < ambienti.length; i++)
	{
		sensorNumber= sensorNumber + ambienti[i].Sensori.length;
	}
		
	  
	//stampo numero impianti e numero sensori
	var content='<div class="row"><div class="col s12 m6 l3"><div class="card"><div class="card-content dark-orange white-text"><p class="card-stats-title"><i class="mdi-action-store"></i> Numero ambienti</p><h4 class="card-stats-number">'+ambienti.length+'</h4></div></div></div><div class="col s12 m6 l3"> <div class="card"> <div class="card-content satisfy-orange white-text"> <p class="card-stats-title"><i class="mdi-hardware-memory"></i> Numero sensori</p><h4 class="card-stats-number">'+sensorNumber+'</h4> </div></div></div></div></div>';
	  
	  
     for(var i = 0; i < ambienti.length; i++)
	 {
		  
		 content=content+'<div class="section"><div class="row"><div class="col s12 m8 l9"><h4>'+ambienti[i].Nome+'</h4></div><div class="col s12 m4 l3"><a style="margin-top: 20px; margin-bottom: 20px;" href="environment-details.php?id='+ambienti[i].IDAmbiente+'" class="btn waves-effect dingy-dungeon white-text admin-add-number right"><i class="mdi-action-list right"></i>Dettagli ambiente</a></div></div><div class="divider"></div></div></div><div class="row"></div><div class="row">';
		 
		 if(!ambienti[i].Sensori.length) {
			content=content+'<div class="col s12 m12 l12"><h5>Nessun sensore presente in questo ambiente.</h5></div>';
		 }
		
		 
		 var sensori = response[0].Ambienti[i].Sensori;
		 
		 for(var k = 0; k < sensori.length; k++) {
			

			 content=content+'<div class="col s12 m4 l4"><div id="card-reveal" class="section"> <div class="row"> <div class="col s12 m12 l12"></div><div class="col s12 m12 l12"> <div class="row"> <div class="col s12 m12 l12">';


			 if(sensori[k].UnitaMisura === "°C") {
				content=content+'<div class="card"> <div class="card-image waves-effect waves-block waves-light card1-color">';
				
			 }

			 else if(sensori[k].UnitaMisura === "%") {
				content=content+'<div class="card"> <div class="card-image waves-effect waves-block waves-light card2-color">';
			 }

			 else if(sensori[k].UnitaMisura === "mbar") {
				content=content+'<div class="card"> <div class="card-image waves-effect waves-block waves-light card3-color">';
			 }

			 else if(sensori[k].UnitaMisura === "lx") {
				content=content+'<div class="card"> <div class="card-image waves-effect waves-block waves-light card4-color">';
			 }

			 else {
				content=content+'<div class="card"> <div class="card-image waves-effect waves-block waves-light teal">';
			 }
			 
			 content=content+'<canvas id="'+sensori[k].IDSensore+'" style="margin-top: 15px; height: 100%!important; width: 92%!important; margin-left:15px;"></canvas> </div><div class="card-content"> <span class="card-title activator grey-text text-darken-4"><a href="sensor-details.php?id='+sensori[k].IDSensore+'">'+sensori[k].Nome+'</a><i class="mdi-action-info-outline right"></i></span></div><div class="card-reveal"> <span class="card-title grey-text text-darken-4">'+sensori[k].Nome+'<i class="mdi-navigation-close right"></i></span>';

			 if(sensori[k].Min === null) {
				content=content+ '<p>Nessuna rilevazione è stata effettuata dal sensore.</p></div></div></div></div></div></div></div></div>';
			 }
			 else {
				var unitaMisura = sensori[k].UnitaMisura;
			 	content=content+ '<h5>MIN: '+sensori[k].Min+" "+unitaMisura+'</h5><br><h5>MAX: '+sensori[k].Max+" "+unitaMisura+'</h5><br><h5>MEDIA: '+sensori[k].Media+" "+unitaMisura+'</h5></div></div></div></div></div></div></div></div>';
			 }
		 }

		 content=content+'</div>';
		 

 	  }
	  
	 $("#dashboard-content").html(content);
	 
	 printCharts(response);	

}



function printCharts(response) {
	
	
	var ambienti2 = response[0].Ambienti;

	 
	 for(var i = 0; i < ambienti2.length; i++)
	 {
			
	    var sensori = response[0].Ambienti[i].Sensori;

		
		for(var k = 0; k < sensori.length; k++) {

			var dati = [];
			var labels = [];
			
			var rilevazioni = sensori[k].Rilevazioni;
			
			for(var j = 0; j < rilevazioni.length; j++) {
				dati[j] = rilevazioni[j].value;
				labels[j] = getData(rilevazioni[j].Data);
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
			var idsensore = sensori[k].IDSensore;
			var grafico = document.getElementById(idsensore).getContext("2d");

			
			drawChart(grafico, LineChartSampleData, sensori[k].UnitaMisura);

		}

		

	}
}

function drawChart(grafico, LineChartSampleData, unitaMisura){
	
	new Chart(grafico).Line(LineChartSampleData, {scaleGridLineColor : "rgba(255,255,255,0.4)", scaleFontColor: "#fff", tooltipTemplate: "<%if (label){%><%=label %>: <%}%><%= value + ' "+unitaMisura+" ' %>"});
	
}


function getData(data) {
	var ore = new Date(data).getHours();
	var minuti = new Date(data).getMinutes();
	return ore + ":" + minuti; 
}


