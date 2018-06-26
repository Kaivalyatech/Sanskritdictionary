<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>DLI Mirror</title>
	
	<link data-n-head="true" rel="icon" type="image/x-icon" href="../sanskritdictionary/favicon.ico">
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/landing-page.css" rel="stylesheet">
    <link href="css/jquery-ui.min.css" rel="stylesheet">
    

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
     <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <script src="js/jquery.js"></script>
    <script src="js/jquery-ui.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    
    <script>
    $(document).ready(function(){	
		$("#author").autocomplete({
			source: "functions.php?From=author",
			minLength: 0,
			select: function(event,ui){
				$('#author').val(ui.item.value);
				$('#authorid').val(ui.item.id);		
				displaybook('author');		
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
				displaybook('subject');			
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
				displaybook('title');			
			}
		}).focus(function () {
			$(this).autocomplete("search");
		});	
		$("#institution").autocomplete({
			source: "functions.php?From=institution",
			minLength: 0,
			select: function(event,ui){
				$('#institution').val(ui.item.value);
				$('#institutionid').val(ui.item.id);		
				displaybook('institution');		
			}
		}).focus(function () {
			$(this).autocomplete("search");
		});
	});
	
	function displaybook(Whichfield){
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
                <a class="navbar-brand topnav" href="index.php" style="width: 108px;"><img src="img/ssd_small.52230aa.gif"></a>
                <div class="searchdiv"><input type="text" placeholder="Search books" class="search"></div>
            </div>
           
        </div>
        <!-- /.container -->
    </nav>


    <!-- Header -->
    <a name="about"></a>
    <div class="intro-header">
        <div class="container">

            <div class="row">
				<div class="content-div">
					<div class="col-lg-3" style="border: 1px solid #aaa;padding: 20px;text-align: left;border-right: none;">
						<input type="hidden" name="authorid" id="authorid">
						<input type="text" name="author" id="author" placeholder="Authors" class="input">
						<input type="hidden" name="subjectid" id="subjectid">
						<input type="text" name="subject" id="subject" placeholder="Subjects" class="input">
						<input type="hidden" name="titleid" id="titleid">
						<input type="text" name="title" id="title" placeholder="Titles" class="input">
						<input type="hidden" name="institutionid" id="institutionid">
						<input type="text" name="institution" id="institution" placeholder="Institutions" class="input">
					</div>
                    <div class="col-lg-9" id="searchresult">
						
					</div>   
                </div>
            </div>

        </div>
        <!-- /.container -->

    </div>
    <!-- /.intro-header -->

    <!-- Page Content -->


    <!-- Footer -->
    <footer style="margin-top: 91px;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">                    
                    <p class="copyright text-muted small" style="text-align:center">A mirror of the Digital Library of India | <a href="http://www.dli.ernet.in/static/dli/copyright.html">DLI Copyright policy</a>  <img src="img/jaja.7e363e1.png"></p>                    
                </div>
            </div>
        </div>
    </footer>
	
	<style>
		.navbar-header{
			width:100%;
		}
		.navbar-brand {
			height: 80px;
			padding: 5px;
		}
		.navbar-brand img{
			width: 100%;
		}
		.searchdiv{
			float: left;
			padding: 25px;
			width: 25%;
		}
		.search{
			border: 1px solid #ccc;			
			padding: 5px;
			border-top: none;
			background: transparent;
			border-left: none;
			border-right: none;
			color: #555;
			width:100%;
		}
		footer{
			/*position: fixed;
			bottom: 0;
			width: 100%*/
		}
		.input {
			padding: 5px;
			margin: 20px 0px;
			border: 1px solid #ccc;
			border-top: none;
			border-right: none;
			border-left: none;
			width: 100%;
			color: #555;
			background: transparent;
		}
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
		}
		@media (max-width:450px){
			.ui-corner-all{
				font-size: 14px;	
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
		}
		@media (min-width:968px) and (max-width:1200px){
			.container {
				width: 950px !important;
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
		}
		.bookdiv{width: 19%;height: 304px;font-size: 16px;line-height: 2.5;background: #ddd;padding: 10px;border: 1px solid #aaa;float: left;margin: 10px 0px 10px 10px;}
		#searchresult{border: 1px solid #aaa;text-align: left;color:#000;height: 326px;float:left}
	</style>
	
    <!-- jQuery -->
   
	
</body>

</html>
