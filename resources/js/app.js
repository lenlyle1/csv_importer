var CSVexporter = {
	getData: function(){
		// ajax in data

		//
	}
}


// load date picker
$(function() {
  	$('input[name="daterange"]').daterangepicker({
    	opens: 'center',
    	showDropdowns: true,
    	opens: 'center',
		locale: {
		  cancelLabel: 'Clear'
		}
  	}, function(start, end, label) {
    	console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
  	});
});

