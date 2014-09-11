$(document).ready(function() {
	var loadings = $("#status");
	loadings.hide();
	loadings.fadeIn(800);	
	setTimeout(function(){
		$('#status').fadeOut(1000, function() {
		});				
	}, 3000);	

	var loading = $("#loading");
	loading.fadeOut();	
	$('input[type="submit"]').click(function(e){
		if( e.which != 2 ) {
			loading.fadeIn();
		   }
	});	
		
	$('.link').click(function(e){
		if( e.which != 2 ) {
		loading.fadeIn();
		   }
	});
		
	$('.ctedit').click(function(e){
		if( e.which != 2 ) {
		loading.fadeIn();
		   }
	});	
	 
	$("#gofull").click(function(){
		var src = "full";
		$.post("themes/fiyo/module/view.php", {"view": src});					
		$("#warp").removeClass("warp");
		$("#warp2").removeClass("warp");				
			
		setTimeout(function(){
			loading.fadeOut(function() {
			});				
		});	
	});	
		
	$("#gowarp").click(function(){
		var src = "warp";
		$.post("themes/fiyo/module/view.php", {"view": src});					
			
		$("#warp").addClass("warp");
		$("#warp2").addClass("warp");				
			
		setTimeout(function(){
			loading.fadeOut(function() {
			});				
		});	
	});
	
	
	
	$('.alphanumeric').alphanumeric();
	$('.nocaps').alpha({nocaps:true});
	$('.numeric').numeric();
	$('.numericdot').numeric({allow:"."});
	$('.selainchar').alphanumeric({ichars:'.1a'});
	$('.web').alphanumeric({allow:':/.-_'});
	$('.email').alphanumeric({allow:':.-_@'});
	
	
	
	
});