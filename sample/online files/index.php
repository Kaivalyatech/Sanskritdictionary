<!DOCTYPE html>
<?php 
	include 'conn.php';	
?>
<html lang="en">
	<head>
		<?php include "header.php"; ?> 		   
		<script>
			$(document).ready(function(){	
				$("#author").autocomplete({
					source: "autocompletefunction.php?From=author",
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
						$('.search').val("");	
						displayresult('author',ui.item.value);		
					}
				}).focus(function () {
					$(this).autocomplete("search");
				});	
				$("#subject").autocomplete({
					source: "autocompletefunction.php?From=subject",
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
						$('.search').val("");
						displayresult('subject',ui.item.value);		
					}
				}).focus(function () {
					$(this).autocomplete("search");
				});	
				$("#title").autocomplete({
					source: "autocompletefunction.php?From=title",
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
						$('.search').val("");
						displayresult('title',ui.item.value);			
					}
				}).focus(function () {
					$(this).autocomplete("search");
				});	
				$("#institution").autocomplete({
					source: "autocompletefunction.php?From=institution",
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
						$('.search').val("");
						displayresult('institution',ui.item.value);	
					}
				}).focus(function () {
					$(this).autocomplete("search");
				});
			});		
			
			function displayresult(WhichField,Value){
				$(".modal").css('display','block');
				$(".Header").html('Search term - "'+Value+'"');
				if(WhichField=="mainsearch"){
					$('#author').val("");	
					$('#author').closest('.input').removeClass('input--filled');
					$('#subject').val("");	
					$('#subject').closest('.input').removeClass('input--filled');
					$('#title').val("");
					$('#title').closest('.input').removeClass('input--filled');
					$('#institution').val("");
					$('#institution').closest('.input').removeClass('input--filled');
				}
				$.ajax({
					url: 'functions.php?WhichField='+WhichField+'&Value='+encodeURIComponent(Value),
					success: function (data) {
						//alert(data);
						$('#searchresult').html(data);
						$( ".modal" ).delay( 800 ).fadeIn( "slow", function() {
							$(this).css('display','none');
						});
					}
				});
			}								
		</script>
	</head>
	<body>
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
					<a class="navbar-brand topnav" href="" style="width: 108px;"><img src="img/ssd_small.52230aa.gif"></a>
					<div class="searchdiv"><input type="text" placeholder="Search books" class="search" value="" name="search" onkeyup="displayresult('mainsearch',this.value)"></div>
					<p class="copyright" style="float:right;font-weight: normal;text-align: right;">A mirror of the Digital Library of India | <a href="http://www.dli.ernet.in/static/dli/copyright.html">DLI Copyright policy </a><img src="img/jaja.7e363e1.png" style="width: 10%;"></p> 
				</div>
			   
			</div>
			<!-- /.container -->
		</nav>

		<?php
			/*$sql="SELECT * FROM books";
			$result = mysqli_query($conn,$sql);
			$numofrows=mysqli_num_rows($result);
			echo "here--".$numofrows;*/
			
			$sql="SELECT MIN(dc_date_citation) as Maxcitationvalue FROM books WHERE dc_date_citation<>''";
			$result = mysqli_query($conn,$sql);
			$row=mysqli_fetch_assoc($result);
			//echo "here".$row['Maxcitationvalue'];
		?>
		<!-- Page Content -->
		<div class="intro-header">
			<div class="container">
				<div class="row">
					<div class="Header"></div>
					<div class="content-div">
						<div class="col-lg-12 categorydiv">
							<div class="col-lg-12"><p style="color: #000000;font-size: 16px;padding-left: 15px;">Select search conditions</p></div>
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
						<div class="col-lg-12" id="searchresult"></div>   
						<div class="modal"></div>
					</div>
				</div>
			</div>
			<!-- /.container -->
		</div>
		<!-- /.intro-header -->
		<!-- /.Page Content -->

		<!-- Footer -->
		<!--<footer style="margin-top: 89px;border: 1px solid #e7e7e7;">
			<div class="container">
				<div class="row">
					<div class="col-lg-12">                    
						<p class="copyright text-muted small" style="text-align:center">A mirror of the Digital Library of India | <a href="http://www.dli.ernet.in/static/dli/copyright.html">DLI Copyright policy</a>  <img src="img/jaja.7e363e1.png"></p>                    
					</div>
				</div>
			</div>
		</footer>-->
		
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
					$('.search').val("");
					displayresult('rangefilter',this.value);
				});
			  });
			};
			rangeSlider();
			
			function OpenFile(Id){
				//alert(Id);
				window.open('bookpage.php?Id='+Id);
			}
		</script>		
	</body>
</html>
