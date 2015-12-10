<?php
include "cssmenu/header.html";

if(!isset($_GET['jobId'])) {
	echo "<form action='showQuality.php' method='get'>
	 <p>Job ID:<input type='text' value='0' name='jobId' /></p>
	 <p><input type='submit' /></p>
	</form>";
}
else {
    include("showPSNRD3.php");
	/*echo "<html>
	  <head>
	    <!--Load the AJAX API-->
	    <script type='text/javascript' src='https://www.google.com/jsapi'></script>
	    <script type='text/javascript' src='//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script>
	    <script type='text/javascript'>
	    
	    // Load the Visualization API and the piechart package.
	    google.load('visualization', '1', {'packages':['corechart']});
	      
	    // Set a callback to run when the Google Visualization API is loaded.
	    google.setOnLoadCallback(drawChart);
	    
	    function drawChart() {
	      	var jsonData = $.ajax({
	        	url: 'getData.php?jobId=" . $_GET['jobId'] . "',
	          	dataType: 'json',
	          	async: false
	        }).responseText;
	          
	      	// Create our data table out of JSON data loaded from server.
	      	var data = new google.visualization.DataTable(jsonData);
			var options = {
				title: 'PSNR over all frames',
				vAxis: {
					format: '# dB',
					viewWindow:{
						max:100,
						min:0
					}
				},
				hAxis: {
					title:'# of Frame'
				},
				explorer: {
					actions: ['dragToZoom', 'rightClickToReset'],
					axis: 'horizontal',
					maxZoomOut: 1,
					maxZoomIn: 0.1,
					keepInBounds: true
				},
				'chartArea': {
				    'backgroundColor': {
				        'fill': '#F1F1F1',
				        'opacity': 100
				     }
				 }
			};
	      	// Instantiate and draw our chart, passing in some options.
	      	var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
	      	chart.draw(data, options);
	    }
	
	    </script>
	  </head>
	
	  <body>
	    <!--Div that will hold the pie chart-->
	    <div id='chart_div'></div>
	  </body>
	</html>";*/
}
include "cssmenu/footer.html";
?>