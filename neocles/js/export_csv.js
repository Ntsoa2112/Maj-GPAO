function exp(){
	var csv = $('#table_1').table2CSV({separator : ';',delivery:'value'});
	window.location.href = 'data:text/csv;charset=UTF-8,'+ encodeURIComponent(csv);	
}
