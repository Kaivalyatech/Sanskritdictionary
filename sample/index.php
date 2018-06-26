<!DOCTYPE html>
<?php include 'conn.php';?>
<html lang="en">
	<head>
		<?php include "header.php"; ?> 		   
		<script>
			$(document).ready(function(){	
				$("#author").autocomplete({
					source: "functions.php?From=author",
					minLength: 0,
					select: function(event,ui){
						$('#author').val(ui.item.value);
						$('#authorid').val(ui.item.id);	
						$('#ui-id-1').scrollTop(0);
						$('#subject').val("");	
						$('#subject').closest('.input').removeClass('input--filled');
						$('#title').val("");
						$('#title').closest('.input').removeClass('input--filled');
						$('#institution').val("");
						$('#institution').closest('.input').removeClass('input--filled');
						displaybook('author',ui.item.value);		
					}
				}).focus(function () {
					$(this).autocomplete("search");
				});	
				$("#subject").autocomplete({
					source: "functions.php?From=subject",
					minLength: 0,
					select: function(event,ui){
						$('#subject').val(ui.item.value);
						$('#subjectid').val(ui.item.id);
						$('#ui-id-2').scrollTop(0);
						$('#author').val("");
						$('#author').closest('.input').removeClass('input--filled');
						$('#title').val("");
						$('#title').closest('.input').removeClass('input--filled');
						$('#institution').val("");
						$('#institution').closest('.input').removeClass('input--filled');
						displaybook('subject',ui.item.value);			
					}
				}).focus(function () {
					$(this).autocomplete("search");
				});	
				$("#title").autocomplete({
					source: "functions.php?From=title",
					minLength: 0,
					select: function(event,ui){
						$('#title').val(ui.item.value);
						$('#titleid').val(ui.item.id);	
						$('#ui-id-3').scrollTop(0);
						$('#author').val("");
						$('#author').closest('.input').removeClass('input--filled');					
						$('#subject').val("");	
						$('#subject').closest('.input').removeClass('input--filled');
						$('#institution').val("");
						$('#institution').closest('.input').removeClass('input--filled');
						displaybook('title',ui.item.value);			
					}
				}).focus(function () {
					$(this).autocomplete("search");
				});	
				$("#institution").autocomplete({
					source: "functions.php?From=institution",
					minLength: 0,
					select: function(event,ui){
						$('#institution').val(ui.item.value.slice(0,5));
						$('#institutionid').val(ui.item.id);
						$('#ui-id-4').scrollTop(0);						
						$('#author').val("");
						$('#author').closest('.input').removeClass('input--filled');					
						$('#subject').val("");	
						$('#subject').closest('.input').removeClass('input--filled');				
						$('#title').val("");
						$('#title').closest('.input').removeClass('input--filled');
						displaybook('institution',ui.item.value);						
					}
				}).focus(function () {
					$(this).autocomplete("search");
				});
			});
			$( function() {
				$( "#datepicker" ).datepicker({
					showOn: "button",
					buttonText: "<i class='fa fa-calendar'></i>",
					prevText: '<i class="fa fa-chevron-left"></i>',
					nextText: '<i class="fa fa-chevron-right"></i>',
					showButtonPanel: true,
					changeMonth: true,
					changeYear: true,
					dateFormat: 'dd-mm-yy',
					onSelect: function() {
						alert("Selected date: " + this.value);
						displaybook('',this.value,'datesearch');
					}
				});
				$( "#datepicker" ).datepicker( "option", "showAnim", "clip" );
				
			} );
			/*function displaybook(Whichfield){
				var AuthorId=$('#authorid').val();
				var SubjectId=$('#subjectid').val();
				var TitleId=$('#titleid').val();
				var InstitutionId=$('#institutionid').val();
				$.ajax({
					url: 'functions.php?From=displaybook&AuthorId='+AuthorId+'&SubjectId='+SubjectId+'&TitleId='+TitleId+'&InstitutionId='+InstitutionId,
					success: function (data) {
						//alert(data);
						$('#searchresult').html(data);
					}
				});
			}*/
			
			function displaybook(Whichfield,Value,From){
				//alert("val--"+Value);
				if(From=="mainsearch"){
					$(".modal").css('display','block');
					//alert(Value);
					var url='functions.php?From=mainsearch&Value='+Value;
				}else if(From=="datesearch"){
					//alert(Value);
					var url='functions.php?From=datesearch&Value='+Value;
				}else if(From=="rangefilter"){
					//alert(Value);
					var url='functions.php?From=rangefilter&Value='+Value;
				}else{
					var url='functions.php?From=displaybook&Whichfield='+Whichfield+'&Value='+encodeURIComponent(Value);
				}
				$.ajax({
					url: url,
					success: function (data) {
						//alert(data);
						$('#searchresult').html(data);
						if(From=="mainsearch"){
							$( ".modal" ).delay( 800 ).fadeIn( "slow", function() {
								$(this).css('display','none');
							});
						}
					}
				});
			}
		</script>
	</head>

	<body style="background: url(img/bg16.png);background-attachment: fixed;">

		<!-- Navigation -->
		<nav class="navbar navbar-default navbar-fixed-top topnav" role="navigation">
			<div class="container topnav">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand topnav" href="index.php" style="width: 108px;"><img src="img/ssd_small.52230aa.gif"></a>
					<div class="searchdiv"><input type="text" placeholder="Search books" class="search" value="" name="search" onkeyup="displaybook('',this.value,'mainsearch')"></div>
				</div>
			   
			</div>
			<!-- /.container -->
		</nav>

		<?php
		$sql="SELECT MIN(dc_date_citation) as Maxcitationvalue FROM books WHERE dc_date_citation<>''";
		$result = mysql_query($sql);
		$row=mysql_fetch_assoc($result);
		echo "here".$row['Maxcitationvalue'];
		?>
		<!-- Header -->
		<a name="about"></a>
		<div class="intro-header">
			<div class="container">

				<div class="row">
					<div class="content-div">
						<!--<div class="col-md-3" style="padding:0px"><input type="text" id="datepicker" style="float:left;color:#000"></div>-->
						<div class="col-lg-12 categorydiv" style="background:#FFE474;/*#EEF6C7;*//*background:#F6CD1D;background: #FFD020;*/padding-left:0px">
							<div class="col-lg-2-5">
								<input type="hidden" name="authorid" id="authorid">
								<span class="input input--madoka">
									<input type="text" name="author" id="author" class="input__field input__field--madoka">
									<label class="input__label input__label--madoka" for="author">
										<svg class="graphic graphic--madoka" width="100%" height="100%" viewBox="0 0 404 77" preserveAspectRatio="none">
											<path d="m0,0l404,0l0,77l-404,0l0,-77z"/>
										</svg>
										<span class="input__label-content input__label-content--madoka">Authors</span>
									</label>
								</span>
							</div>
							<div class="col-lg-2-5">
								<input type="hidden" name="subjectid" id="subjectid">
								<span class="input input--madoka">
									<input type="text" name="subject" id="subject" class="input__field input__field--madoka">
									<label class="input__label input__label--madoka" for="subject">
										<svg class="graphic graphic--madoka" width="100%" height="100%" viewBox="0 0 404 77" preserveAspectRatio="none">
											<path d="m0,0l404,0l0,77l-404,0l0,-77z"/>
										</svg>
										<span class="input__label-content input__label-content--madoka">Subjects</span>
									</label>
								</span>
							</div>
							<div class="col-lg-2-5">
								<input type="hidden" name="titleid" id="titleid">
								<span class="input input--madoka">
									<input type="text" name="title" id="title" class="input__field input__field--madoka">
									<label class="input__label input__label--madoka" for="title">
										<svg class="graphic graphic--madoka" width="100%" height="100%" viewBox="0 0 404 77" preserveAspectRatio="none">
											<path d="m0,0l404,0l0,77l-404,0l0,-77z"/>
										</svg>
										<span class="input__label-content input__label-content--madoka">Titles</span>
									</label>
								</span>
							</div>
							<div class="col-lg-2-5">
								<input type="hidden" name="institutionid" id="institutionid">
								<span class="input input--madoka">
									<input type="text" name="institution" id="institution" class="input__field input__field--madoka">
									<label class="input__label input__label--madoka" for="institution">
										<svg class="graphic graphic--madoka" width="100%" height="100%" viewBox="0 0 404 77" preserveAspectRatio="none">
											<path d="m0,0l404,0l0,77l-404,0l0,-77z"/>
										</svg>
										<span class="input__label-content input__label-content--madoka">Institutions</span>
									</label>
								</span>
							</div>
							<div class="col-lg-2-5">
								<p style="color: #63223c;margin-top: 26px;font-size: 17px;padding-left: 1em;margin-bottom: 5px">Date Filter</p>
								<div class="range-slider">
									<input class="range-slider__range" type="range" value="0" min="0" max="<?php echo $row['Maxcitationvalue'];?>">
									<span class="range-slider__value">0</span>
								</div>
							</div>
						</div>
						<div class="col-lg-12" id="searchresult">
							
							
						</div>   
						<div class="modal"></div>
					</div>
				</div>

			</div>
			<!-- /.container -->

		</div>
		<!-- /.intro-header -->

		<!-- Page Content -->


		<!-- Footer -->
		<footer style="margin-top: 89px;border: 1px solid #e7e7e7;">
			<div class="container">
				<div class="row">
					<div class="col-lg-12">                    
						<p class="copyright text-muted small" style="text-align:center">A mirror of the Digital Library of India | <a href="http://www.dli.ernet.in/static/dli/copyright.html">DLI Copyright policy</a>  <img src="img/jaja.7e363e1.png"></p>                    
					</div>
				</div>
			</div>
		</footer>
		
		<style>
			.navbar-header{width:100%;}.navbar-brand {height: 80px;padding: 5px;}.navbar-brand img{width: 100%;}.searchdiv{float: left;padding: 25px;width: 25%;}.search{border: 1px solid #ccc;padding: 5px;border-top: none;background: transparent;border-left: none;border-right: none;color: #555;width:100%;}footer{/*position: fixed;bottom: 0;width: 100%*/}.input {/*padding: 10px;margin: 20px 0px;border: 2px solid #fff;width: 100%;color: #777;background: transparent;*//*padding: 5px;margin: 20px 0px;border: 1px solid #444;border-top: none;border-right: none;border-left: none;width: 100%;color: #000;background: transparent;*/}		

			/* Madoka input box css starts */
			.input {position: relative;z-index: 1;display: inline-block;margin: 1em;/*max-width: 350px;*/width: calc(100%);vertical-align: top;}.input__field {position: relative;display: block;float: right;padding: 1em;width: 60%;border: none;border-radius: 0;background: #f0f0f0;color: #aaa;font-weight: bold;font-size: 16px;-webkit-appearance: none;}.input__field:focus {outline: none;}.input__label {display: inline-block;float: right;padding: 0 1em;width: 40%;color: #6a7989;font-weight: bold;font-size: 70.25%;-webkit-font-smoothing: antialiased;-moz-osx-font-smoothing: grayscale;-webkit-touch-callout: none;-webkit-user-select: none;-khtml-user-select: none;-moz-user-select: none;-ms-user-select: none;user-select: none;}.input__label-content {position: relative;display: block;padding: 0.6em 0 0em;width: 100%;font-size: 17px;}.graphic {position: absolute;top: 0;left: 0;fill: none;}.icon {color: #ddd;font-size: 150%;}.input--madoka {margin: 1.1em;}.input__field--madoka {width: 100%;background: transparent;color: #63223c;}.input__label--madoka {position: absolute;width: 100%;height: 100%;color: #63223c;text-align: left;cursor: text;}.input__label-content--madoka {-webkit-transform-origin: 0% 50%;transform-origin: 0% 50%;-webkit-transition: -webkit-transform 0.3s;transition: transform 0.3s;}.graphic--madoka {-webkit-transform: scale3d(1, -1, 1);transform: scale3d(1, -1, 1);-webkit-transition: stroke-dashoffset 0.3s;transition: stroke-dashoffset 0.3s;pointer-events: none;stroke: #63223c;stroke-width: 4px;stroke-dasharray: 962;stroke-dashoffset: 558;}.input__field--madoka:focus + .input__label--madoka,.input--filled .input__label--madoka {cursor: default;pointer-events: none;}.input__field--madoka:focus + .input__label--madoka .graphic--madoka,.input--filled .graphic--madoka {stroke-dashoffset: 0;}.input__field--madoka:focus + .input__label--madoka .input__label-content--madoka,.input--filled .input__label-content--madoka {-webkit-transform: scale3d(0.81, 0.81, 1) translate3d(0, -2.5em, 0);transform: scale3d(0.81, 0.81, 1) translate3d(0, -2.5em, 0);}

			.navbar-default .navbar-toggle{
				display:none;
			}
			.content-div{
				padding-top: 5%;
			}
			@media (max-width:350px){
				.content-div{
					padding-top: 46%;
				}
				.searchdiv{
					width:100%;
				}	
				.input--madoka{
					margin:1em 0 !important;
				}
			}
			@media (max-width:450px){
				.ui-corner-all{
					font-size: 14px;	
				}
				.input--madoka{
					margin:1em 0 !important;
				}
			}
			.ui-corner-all{
				overflow-y: auto;
				overflow-x: hidden;
				position: absolute;		
			}
			@media (max-width:619px){
				.bookdiv{
					margin:10px 0px 10px 0px !important;
					width:100% !important;
				}
				#searchresult{
					width:100%;
				}
			}
			@media (min-width:620px) and (max-width:767px){
				.bookdiv{
					margin:10px 0px 10px 10px !important;
					width:48% !important;
				}
				#searchresult{
					width:100%;
				}
				.categorydiv{
					margin-right:1px solid #aaa;
				}
			}
			@media (min-width:1600px){
				.container {
					width: 1554px;
				}
				.categorydiv{
					//border-right: none !important;
				}
			}
			@media (min-width:1501px) and (max-width:1599px){
				.container {
					width: 1480px;
				}
				.categorydiv{
					//border-right: none !important;
				}
			}
			@media (min-width:768px) and (max-width:1200px){
				.content-div{
					padding-top: 6%;
				}
				.searchdiv{
					width:50%;
				}
				.bookdiv{
					margin:10px 0px 10px 10px !important;
					width:23% !important;
				}
				#searchresult{
					width:100%;
				}			
				.input--madoka{
					margin:1em 0 !important;
				}
			}
			@media (min-width:351px) and (max-width:767px){
				.categorydiv{
					//border-right: none !important;
				}
				.searchdiv {
					width: 65%;
				}
				.input--madoka{
					margin:1em 0 !important;
				}
			}
			/*.bookdiv{width: 19%;height: 340px;font-size: 16px;line-height: 2.5;background: #ddd;padding: 10px;border: 1px solid #aaa;float: left;margin: 10px 0px 10px 10px;}*/
			.bookdiv{position: relative;width: 18%;margin: 12px 10px;float:left;box-shadow: 0px 1px 5px 1px #999;}
			.bookdiv img{width: 100%;height: 300px;}
			.bookdiv:hover{box-shadow: 0px 1px 5px 1px #333;}
			.emptydiv{margin: 130px auto;width: 50%;text-align: center;font-size: 25px;}
			#searchresult{border: 1px solid #aaa;text-align: left;color:#000;height: 326px;float:left;background: #eee;box-shadow:0px 3px 6px 1px #ccc}
			.categorydiv{border: 1px solid #aaa;padding: 20px;text-align: left;box-shadow:-3px 3px 6px 1px #ccc}
			.ui-menu .ui-menu-item a{position:relative;}.ui-corner-all{width:275px !important;max-height: 250px;}
			.Header{padding: 10px 0px;text-align: center;color: #63223c;background: #aaa;margin: 0px -15px;font-size: 18px;}
			.text {float: left;position: absolute;left: 0px;/*top: 0px;*/bottom:0px;z-index: 1000;/*background-color: #92AD40;*/background-color:#E9CE5E/*#333*/;padding: 5px;color: #000000/*#FFFFFF*/;font-weight: bold;width:100%;text-overflow: ellipsis;white-space: nowrap;overflow: hidden;}
			
			/*Date picker css starts here*/
			/*.ui-datepicker.ui-widget-content {overflow: hidden;}.ui-datepicker-trigger{float:left;border: 2px solid #aaa;padding: 5px 10px;background: #fff;border-radius: 0px 5px 5px 0px;border-left: 0px;background:#bbb;}.ui-datepicker-trigger .fa{color:#000;font-size: 21px;}.ui-datepicker-header.ui-corner-all {width: 291px !important;}.ui-datepicker.ui-corner-all {width: 300px !important;}.ui-datepicker-next.ui-corner-all,.ui-datepicker-prev.ui-corner-all {width: 25px !important;overflow-y: hidden;}#datepicker{float: left;color: #000;padding: 6px 10px;border: 2px solid #aaa;border-radius: 5px 0px 0px 5px;border-right: 0px;}*/

			/*range filter css starts here*/
			.range-slider {width: 100%;padding: 2px 5px 0px;background: #FFE474/*#EEF6C7*/;margin: -6.5px 1em 1.1em 0em;margin-bottom: 0px;}.range-slider__range {width: calc(100% - (73px)) !important;height: 6px;border-radius: 5px;background: #ccc;outline: none;padding: 0;margin: 0;display: inline-block !important;cursor: pointer;}.range-slider__value {display: inline-block;position: relative;width: 60px;color: #fff;line-height: 20px;text-align: center;border-radius: 3px;background: #63223c;padding: 5px 10px;margin-left: 8px;box-shadow:.5px .5px 2px 1px rgba(0,0,0,.32);}.range-slider__value::after {position: absolute;top: 8px;left: -7px;width: 0;height: 0;border-top: 7px solid transparent;border-right: 7px solid #63223c;border-bottom: 7px solid transparent;content: '';}.range-slider__range::-moz-range-thumb {background:#63223c;border: 0;width:20px;height:20px;border-radius: 50%;cursor: pointer;transition: background .15s ease-in-out;box-shadow:.5px .5px 2px 1px rgba(0,0,0,.32);}.range-slider__range:active::-moz-range-thumb {background: #63223c;}.range-slider__range::-moz-range-thumb:hover {background: #777;}::-moz-range-track {background: #ccc;border: 0;}input::-moz-focus-inner,input::-moz-focus-outer { border: 0; }
			
			.modal {
				display:    none;
				position:   fixed;
				z-index:    1000;
				top:        0;
				left:       0;
				height:     100%;
				width:      100%;
				background: rgba( 255, 255, 255, .4 ) 
							url('./img/loader.gif') 
							50% 50% 
							no-repeat;
			}
		</style>
		
		<!-- Textbox jQuery -->
		<script src="js/classie.js"></script>
		<script>
			<!--Textbox script-->
			(function() {
				// trim polyfill : https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/Trim
				if (!String.prototype.trim) {
					(function() {
						// Make sure we trim BOM and NBSP
						var rtrim = /^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g;
						String.prototype.trim = function() {
							return this.replace(rtrim, '');
						};
					})();
				}

				[].slice.call( document.querySelectorAll( 'input.input__field' ) ).forEach( function( inputEl ) {
					// in case the input is already filled..
					if( inputEl.value.trim() !== '' ) {
						classie.add( inputEl.parentNode, 'input--filled' );
					}

					// events:
					inputEl.addEventListener( 'focus', onInputFocus );
					inputEl.addEventListener( 'blur', onInputBlur );
				} );

				function onInputFocus( ev ) {
					classie.add( ev.target.parentNode, 'input--filled' );
				}

				function onInputBlur( ev ) {
					if( ev.target.value.trim() === '' ) {
						classie.remove( ev.target.parentNode, 'input--filled' );
					}
				}
			})();
			
			<!--Date range slider-->
			var rangeSlider = function(){
			var slider = $('.range-slider'),
			  range = $('.range-slider__range'),
			  value = $('.range-slider__value');
				
			  slider.each(function(){

				value.each(function(){
				  var value = $(this).prev().attr('value');
				  $(this).html(value);
				});

				range.on('input', function(){
					$(this).next(value).html(this.value);
					$('#author').val("");	
					$('#author').closest('.input').removeClass('input--filled');
					$('#subject').val("");	
					$('#subject').closest('.input').removeClass('input--filled');
					$('#title').val("");
					$('#title').closest('.input').removeClass('input--filled');
					$('#institution').val("");
					$('#institution').closest('.input').removeClass('input--filled');
					displaybook('',this.value,'rangefilter');
				});
			  });
			};
			rangeSlider();
		</script>		
	</body>
</html>
