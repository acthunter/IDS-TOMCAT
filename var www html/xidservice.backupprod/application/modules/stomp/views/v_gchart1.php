<!DOCTYPE html>
<html>
<head> 
	<title>jQuery.Gantt - Test Suite 01</title>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=Edge;chrome=1" >
        <link rel="stylesheet" href="assets/css/style.css" />
        <link href="assets/css/bootstrap-combined.min.css" rel="stylesheet">
        <link rel="stylesheet" href="assets/css/prettify.css" />
		<style type="text/css">
			body {
				font-family: Helvetica, Arial, sans-serif;
				font-size: 13px;
				padding: 0 0 50px 0;
			}
			.contain {
				width: 100%;
				margin: 0 auto;
			}
			h1 {
				margin: 40px 0 20px 0;
			}
			h2 {
				font-size: 1.5em;
				padding-bottom: 3px;
				border-bottom: 1px solid #DDD;
				margin-top: 50px;
				margin-bottom: 25px;
			}
			table th:first-child {
				width: 150px;
			}
		</style>
</head> 
<body>
    
	<div class="gantt"></div>
</body>
<script src="assets/js/jquery.min.js"></script>
	<script src="assets/js/jquery.fn.gantt.js"></script>
	<script src="assets/js/moment.min.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/prettify.js"></script>
    <script>
		
		function get_data(){
			var rdata = null;
			$.ajax({
				type: 'GET',
				url: 'http://172.18.4.220/sso1/stomp/xbanc/gen_gchart_db',
				dataType: "json",
				async:true,
				data: {
					Country: "Japan"
				},
				success: function(data) {
					console.log(data);
					update_gantt(data);
				}

			});
		};
		
		function update_gantt(gdata){
			$(".gantt").gantt({
				source: gdata,
				navigate: "scroll",
				maxScale: "hours",
				minScale: "hours",
				scale: "days",
				itemsPerPage: 10,
				onItemClick: function(data) {
					alert("Item clicked - show some details" + data);
				},
				onAddClick: function(dt, rowId) {
					alert("Empty space clicked - add an item!");
				},
				onRender: function() {
					if (window.console && typeof console.log === "function") {
						console.log("chart rendered");
					}
				}
			});
		}
		$(document).ready(function() {
			
			"use strict";
			get_data();
			
			$(".gantt").popover({
				selector: ".bar",
				title: "I'm a popover",
				content: "And I'm the content of said popover.",
				trigger: "hover"
			});

			prettyPrint();

		});
    </script>
</html>