<?php
$Id=$_GET['Id'];
echo $GoogleId;
?>
<html>
	<head>
		<?php include "conn.php"; include "header.php"; ?>
	</head>
	<body>
		<div class="col-md-12" style="padding-left:0px">
			<div class="col-md-8" style="padding-left:0px">
				<iframe src="https://docs.google.com/viewer?srcid=<?php echo $Id;?>&pid=explorer&efh=false&a=v&chrome=false&embedded=true" width="100%" style="height: 98vh;"></iframe>
			</div>
			<div class="col-md-2">
				<?php
					$sql="SELECT * FROM books WHERE google_drive_id='".$Id."'";
					//echo $sql;
					$result = mysqli_query($conn,$sql);
					$row=mysqli_fetch_assoc($result);
					//print_r($row);
				?>
				<ul class="ul-list">
					<li><div class="flex-div"><span>dc_contributor_author:</span><span><?php echo $row['dc_contributor_author'];?></span></div></li>
					<li><div class="flex-div"><span>dc_contributor_other:</span><span><?php echo $row['dc_contributor_other'];?></span></div></li>
					<li><div class="flex-div"><span>dc_date_accessioned:</span><span><?php echo $row['dc_date_accessioned'];?></span></div></li>
					<li><div class="flex-div"><span>dc_date_available:</span><span><?php echo $row['dc_date_available'];?></span></div></li>
					<li><div class="flex-div"><span>dc_date_citation:</span><span><?php echo $row['dc_date_citation'];?></span></div></li>
					<li><div class="flex-div"><span>dc_date_copyrightexpirydate:</span><span><?php echo $row['dc_date_copyrightexpirydate'];?></span></div></li>
					<li><div class="flex-div"><span>dc_date_digitalpublicationdate:</span><span><?php echo $row['dc_date_digitalpublicationdate'];?></span></div></li>
					<li><div class="flex-div"><span>dc_description_alternateuri:</span><span><?php echo $row['dc_description_alternateuri'];?></span></div></li>
					<li><div class="flex-div"><span>dc_description_main:</span><span><?php echo $row['dc_description_main'];?></span></div></li>
					<li><div class="flex-div"><span>dc_description_numberedpages:</span><span><?php echo $row['dc_description_numberedpages'];?></span></div></li>
					<li><div class="flex-div"><span>dc_description_scannerno:</span><span><?php echo $row['dc_description_scannerno'];?></span></div></li>
					<li><div class="flex-div"><span>dc_description_scanningcentre:</span><span><?php echo $row['dc_description_scanningcentre'];?></span></div></li>
					<li><div class="flex-div"><span>dc_description_slocation:</span><span><?php echo $row['dc_description_slocation'];?></span></div></li>
					<li><div class="flex-div"><span>dc_description_tagged:</span><span><?php echo $row['dc_description_tagged'];?></span></div></li>
					<li><div class="flex-div"><span>dc_description_totalpages:</span><span><?php echo $row['dc_description_totalpages'];?></span></div></li>
					<li><div class="flex-div"><span>dc_description_vendor:</span><span><?php echo $row['dc_description_vendor'];?></span></div></li>
					<li><div class="flex-div"><span>dc_format_mimetype:</span><span><?php echo $row['dc_format_mimetype'];?></span></div></li>
					<li><div class="flex-div"><span>dc_identifier:</span><span><?php echo $row['dc_identifier'];?></span></div></li>
					<li><div class="flex-div"><span>dc_identifier_barcode:</span><span><?php echo $row['dc_identifier_barcode'];?></span></div></li>
					<li><div class="flex-div"><span>dc_identifier_copyno:</span><span><?php echo $row['dc_identifier_copyno'];?></span></div></li>
					<li><div class="flex-div"><span>dc_identifier_origpath:</span><span><?php echo $row['dc_identifier_origpath'];?></span></div></li>
					<li><div class="flex-div"><span>dc_identifier_uri:</span><span><?php echo $row['dc_identifier_uri'];?></span></div></li>
					<li><div class="flex-div"><span>dc_language_iso:</span><span><?php echo $row['dc_language_iso'];?></span></div></li>
					<li><div class="flex-div"><span>dc_publisher:</span><span><?php echo $row['dc_publisher'];?></span></div></li>
					<li><div class="flex-div"><span>dc_publisher_digitalrepublisher:</span><span><?php echo $row['dc_publisher_digitalrepublisher'];?></span></div></li>
					<li><div class="flex-div"><span>dc_rights:</span><span><?php echo $row['dc_rights'];?></span></div></li>
					<li><div class="flex-div"><span>dc_rights_holder:</span><span><?php echo $row['dc_rights_holder'];?></span></div></li>
					<li><div class="flex-div"><span>dc_source_library:</span><span><?php echo $row['dc_source_library'];?></span></div></li>
					<li><div class="flex-div"><span>dc_subject_classification:</span><span><?php echo $row['dc_subject_classification'];?></span></div></li>
					<li><div class="flex-div"><span>dc_subject_keywords:</span><span><?php echo $row['dc_subject_keywords'];?></span></div></li>
					<li><div class="flex-div"><span>dc_title:</span><span><?php echo $row['dc_title'];?></span></div></li>
					<li><div class="flex-div"><span>filename:</span><span><?php echo $row['filename'];?></span></div></li>
				</ul>
			</div>
		</div>
	</body>
	<style>
	.flex-div{flex-flow: column nowrap;display: flex;padding-bottom: 13px}
	.ul-list{list-style:none;padding:0px;margin-top: 10px;}
	.flex-div > :first-child {font-size: 18px;color: rgba(0,0,0,.87);font-weight: 500;}
	.flex-div > :nth-child(2), .flex-div > :nth-child(3){color:rgba(0,0,0,.6);font-size:14px;font-weight: normal;}
	</style>
</html>
