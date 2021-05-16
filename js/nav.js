//Checking whether nav is open or no
$(function() {
    
	var openflag = false;
	
	$('#overlayNavBtn').click(function (){
		
		// Check if side nav is open
		if (openflag) {
			openflag = false;
			$('#overlayNavContainer').css("width", "0");
			return;
		}
		
		//Check size of window and resize nav accordingly
		if($(window).width() >= 1200){
			$('#overlayNavContainer').css("width", "20%");
		} else if ($(window).width() <= 1200 && $(window).width() >= 700 ){
			$('#overlayNavContainer').css("width", "40%");
		} else if ($(window).width() <= 700) {
			$('#overlayNavContainer').css("width", "100%");
		}
		openflag = true;
	});	
	

	
});