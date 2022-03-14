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

$('exportButton').on('click', function(){
	console.log('submitting');
})

function exportTasks(_this) {
  	let _url = $(_this).data('href');
    _url += '?daterange='+$('#daterage').val()+'&sort_by='+$('#sort_by').val();
    console.log(_url);
  	window.location.href = _url;
}