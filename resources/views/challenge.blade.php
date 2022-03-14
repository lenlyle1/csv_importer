<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<title>
			CSV Exporter
		</title>
	  	<link rel="stylesheet" href="/css/app.css">
		<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

	  	<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
		<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
		<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"tar -czvf file.tar.gz directory></script>
		<script type="text/javascript" src="/js/app.js"></script>
		<script type="text/javascript">
			
function exportTasks(_this) {
  	let _url = $(_this).data('href');
  	window.location.href = _url;
}
		</script>
	</head>
	<body>
		<div id="content">
			<div>
				<h1>CSV Exporter</h1>
			</div>
			<form id="exportFilters">
				<div class="fieldholder">
					<label for="daterange" >Date Range</label>
					<input id="daterage" type="text" name="datetimes" />
				</div>
				<div class="fieldholder">
					<label for="sort_by" >Sort By</label>
					<select name="sort_by" id="sort_by">
						<option value=""></option>
						<option value="name">Name</option>
						<option value="order_date">Order Date</option>
						<option value="subtotal">Subtotal</option>
						<option value="total">Total</option>
					</select>

				
				</div>
				<div class="export-holder">
					<span data-href="/export" id="export" class="btn btn-success btn-sm" onclick="exportTasks(event.target);">Export</span>
				</div>
			</form>
		</div>
		<div>
			<table>
				<tr>

				</tr>
			</table>
		</div>


		<script>
			$(function() {
			    $('input[name="datetimes"]').daterangepicker({
				    timePicker: true,
				    startDate: '{{ $low->order_date }}',
				    endDate: '{{ $high->order_date }}',
				    showDropdowns: true,
				    locale: {
				      format: 'DD-MM-YYYY'
				    }
			    });
			});
		</script>

	</body>
</html>















