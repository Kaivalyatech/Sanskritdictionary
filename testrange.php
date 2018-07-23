<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>jQuery UI Slider - Range slider</title>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script>
	$( function() {
		$( "#slider-range" ).slider({
			range: true,
			min: 0,
			max: 500,
			values: [ 75, 300 ],
			slide: function( event, ui ) {
				$( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
			}
		});
		$( "#amount" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) +
			" - $" + $( "#slider-range" ).slider( "values", 1 ) );
	} );
	</script>
</head>
<body cz-shortcut-listen="true">

<p>
	<label for="amount">Price range:</label>
	<input id="amount" readonly="" style="border:0; color:#f6931f; font-weight:bold;" type="text">
</p>

<div id="slider-range" class="ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content">
	<span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="left: 15%;"></span>
	<span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="left: 60%;"></span>
</div>




</body>
