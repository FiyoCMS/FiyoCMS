function checkFirstVisit() {
	$(window).bind('onbeforeunload',function(){
		return false;
		window.location.replace(document.URL);

	});  
	$(document).bind('keydown keyup', function(e) {
		if(e.which === 116) {
		   console.log('blocked');
			e.preventDefault();	
		   window.location.replace(document.URL);
		}
		if(e.which === 82 && e.ctrlKey) {
		   console.log('blocked');
			e.preventDefault();	
		   window.location.replace(document.URL);
		}
	});
}

$(function() {
	//checkFirstVisit();
    $('a[href=#]').on('click', function(e){
      e.preventDefault();
    });    
    $('.minimize-box').on('click', function(e) {
        e.preventDefault();
        var $icon = $(this).children('i');
        if ($icon.hasClass('icon-chevron-down')) {
            $icon.removeClass('icon-chevron-down').addClass('icon-chevron-up');
        } else if ($icon.hasClass('icon-chevron-up')) {
            $icon.removeClass('icon-chevron-up').addClass('icon-chevron-down');
        }
    });
	
    $('.close-box').click(function() {
        $(this).closest('.box').hide('slow');
    });

    $('.changeSidebarPos').on('click', function(e) {
        $('body').toggleClass('hide-sidebar');
        $('body').removeClass('user-sidebar');
		$('.changeSidebarPos').toggleClass('removeSidebar');
		$.ajax({
			type: 'POST',
			url: "themes/fiyo/module/view.php",
			data: "view=true"
		});	
    });
	
    $('.userSideBar').on('click', function(e) {
        $('body').toggleClass('user-sidebar');
        $('body').removeClass('hide-sidebar');
    });
    
    $('.removeSidebar').on('click', function(e) {
        $('body').removeClass('hide-sidebar');
        $('body').removeClass('user-sidebar');
    });
	
    $('li.accordion-group > a').on('click',function(e){
        $(this).children('span').children('i').toggleClass('icon-angle-down');
    });		
	
	loadScrollbar();
	loader();
	loadSpinner();
	loadChoosen();
	noticeabs();
	$('.spinner').change(function () {
		$(this).next('label').hide() ;
	});
	
	
});
function loader() {
	$(".cb-enable").click(function(){
		if($(this).parents('.switch-group').length == 0 ) {
			var parent = $(this).parents('.switch');
			$('.cb-disable',parent).removeClass('selected');
			$(this).addClass('selected');
		}		
	});

	$(".cb-disable").click(function(){
		if($(this).parents('.switch-group').length == 0 ) {
			var parent = $(this).parents('.switch');
			$('.cb-enable',parent).removeClass('selected');
			$(this).addClass('selected');
		}
	});	
	
	$('.selectbox li').click(function(){
		$(this).toggleClass('active');
		var checkBoxes = $("input[type='checkbox']", this);
		checkBoxes.prop("checked", !checkBoxes.prop("checked"));
	});
	$('.selections-all').click(function(){
		var t = $('.selectbox li').addClass('active');
		var checkBoxes = $("input[type='checkbox']", t);
		checkBoxes.prop("checked",true);
	});
	$('.selections-reset').click(function(){
		var t = $('.selectbox li').removeClass('active');
		var checkBoxes = $("input[type='checkbox']", t);
		checkBoxes.prop("checked",false);
	});
    $('[data-toggle=popover]').popover();
    $('[data-popover=tooltip]').popover();
    $('[data-toggle=tooltip]').tooltip();
    $('[data-tooltip=tooltip]').tooltip();
    $('.tips').tooltip();
	$('.alphanumeric').alphanumeric();
	$('.alphadot').alphanumeric({allow:"."});
	$('.nocaps').alpha({nocaps:true});
	$('.numeric').numeric();
	$('.numericdot').numeric({allow:"."});
	$('.selainchar').alphanumeric({ichars:'.1a'});
	$('.web').alphanumeric({allow:':/.-_'});
	$('.email').alphanumeric({allow:':.-_@'});
	$("input, select, textarea").addClass('form-control');
	$("input").addClass('form-control');
	$('input[type="checkbox"],input[type="radio"]').wrap("<label>");
	$('input[type="number"]').attr("type","text");
	$('input[type="checkbox"],input[type="radio"]').after("<span class='input-check'>");	
	$("input.form-control[type=password]").parent().wrapInner("<div>");		
	$("[required]").addClass('required').after('<div class="required-input"><i title="Required" data-placement="top">*</i></div>').parent().wrapInner("<div>"
	);		
	
    $('.required-input i').tooltip();
	$("#editor").attr("required","required");
	if ($.isFunction($.fn.validate)) {
		$("body").find("#content form").validate({ ignore: ":hidden:not(select)" });
	}
	$('input[type=date]').attr('type','text').after('<span class="add-on input-group-addon"><i class="icon-calendar"></i></span>').parent().wrapInner("<div class='input-append date input-group'>").datetimepicker();
	
	
}

function selectCheck() {
	$('input[type="checkbox"]').click(function(){	
		var $checked = $(this).is(':checked');
		var $target = $(this).attr('target');
		var $subs = $(this).attr('sub-target');
		if($subs) {
			$target = $(this).attr('value');
			var $checkbox = $('input[data-parent="'+$target+'"]');
		} else {
			var $checkbox = $('input[name="'+$target+'"]');
		}
		$('input[type="checkbox"]').next().removeClass('input-error');
		$('input[type="radio"]').next().removeClass('input-error');		
		if($checked) {			
			$checkbox.prop('checked', 1);					
			$($checkbox).parents('.data tr').addClass('active');					
		}
		else {
			$checkbox.prop('checked', 0);	
			$($checkbox).parents('.data tr').removeClass('active');				
		}
	});
	
	$('[target-radio], label[target], radio-name[target]').click(function(e){			
		var $target = $(this).attr('target-radio');
		var $type = $(this).attr('target-type');
		var $checkbox = $('input[data-name="'+$target+'"]');
		var $checked = $($checkbox).is(':checked');
		if($type == 'multiple')
		var $checkbox = $('input[name="'+$target+'"]');
		$('input[type="checkbox"]').next().removeClass('input-error');
		$('input[type="radio"]').next().removeClass('input-error');
		if($(e.target).is('.switch *, a[href]')) {
		} else {
			$('tr').removeClass('active');	
			if($checked) {
				$checkbox.prop('checked', 0);					
			}
			else {
				$checkbox.prop('checked', 1);	
				if($('tr')) $(this).addClass('active');
			}
		}
	});	
	
}
function loadScrollbar() {
	if ($.isFunction($.fn.niceScroll) ) {
		$("html").niceScroll({cursorcolor:"#000"});
		$("#left").niceScroll({cursorcolor:"#eee"});
		$(".modal").niceScroll();			
		$("textarea:not(#editor)").niceScroll();			
		$(".notice ul").niceScroll();		
	}
}
function loadChoosen() {
	if ($.isFunction($.fn.chosen) ) {
		$("select").chosen({disable_search_threshold: 10});
		$("#article .parameter select").change(function(event) {
			var ini = $(this).val();
			$(this).removeClass("s-1 s-0 s-2");
			$(this).addClass("s-"+ini);
			
		});
	}
	$("select").ready(function(){	
		var cl = $(this).val();
		$(this).next('.chosen-container').attr('rel','selected-'+cl);
		$(".chosen-results").niceScroll();
		$(".selections-box").niceScroll();
		$(".scrolling").niceScroll();
	});
}
function loadTable(url,display) {	
	if(url) {		
        var tr = true;
        var file = url;
	} else  {
		var tr = false;
        var file = null;
	}
	$('table.data').show();
	if ($.isFunction($.fn.dataTable)) {
		oTable = $('table.data').dataTable({
			"iDisplayLength": display,
			"bProcessing": tr,
			"bServerSide": tr,
			"sAjaxSource": file,
			"bJQueryUI": true,
			"sPaginationType": "full_numbers",
			"fnDrawCallback": function( oSettings ) {
				selectCheck();
				$('[data-toggle=tooltip]').tooltip();
				$('[data-tooltip=tooltip]').tooltip();
				$('.tips').tooltip();				
				
				$("tr").click(function(e){
					var i =$("td:first-child",this).find("input[type='checkbox']");					
					var c = i.is(':checked');
					if($(e.target).is('.switch *, a[href]')) {					   
					} else if(i.length) {
						if(c) {
							i.prop('checked', 0);		
							$(this).removeClass('active');			
						}
						else {
							i.prop('checked', 1);
							$(this).addClass('active');
							$('.input-error').removeClass('input-error');
							
						}
					}
				});			
				$('input[type="checkbox"],input[type="radio"]').wrap("<label>");
				$('input[type="checkbox"],input[type="radio"]').after("<span class='input-check'>");
				$('table.data tbody a[href]').on('click', function(e){
				   if ($(this).attr('target') !== '_blank'){
					e.preventDefault();	
					loadUrl(this);
				   }				
				});
			}
		});
		$('table.data th input[type="checkbox"]').parents('th').unbind('click.DT');
		if ($.isFunction($.fn.chosen) ) {
			$("select").chosen({disable_search_threshold: 10});
		}				
	}
}
function loadSpinner() {
	if ($.isFunction($.fn.spinner)) {
		$('.spinner').spinner();
		$('.spinner min-nol').spinner({ min: 0});
		$('#spinnerfast').spinner({ min: -1000, max: 1000, increment: 'fast' });
		$('#spinnerhide').spinner({ min: 0, max: 100, showOn: 'both' });
		$('#spinnernull').spinner({ min: -100, max: 100, allowNull: true });
		$('#spinnerdisable').spinner({ min: -100, max: 100 });
		$('#spinnermaxlen').spinner();
		$('#spinner5').spinner();	
	}
}
function noticeabs(data) {
	var a = $(data);
	if(data) {
		$(".inner .alert").remove();
	} else {
		a = $('.alert');
	}
	a.hide().appendTo("#alert_top");	
	a.fadeIn('slow');
	var a = a.css({margin:'0 auto'});	
	a.on('click', function(e) {
		$(this).fadeOut();		
	}); 
	setTimeout(function(){
		a.fadeOut('slow');
	}, 10000);
	setTimeout(function(){				
		a.remove();	
	}, 11000);	
}

function notice(data) {	
	var c = $("#alert .alert").length;
	if(c > 9) $("#alert .alert:first-child").remove();
	var a = $(data).hide().appendTo("#alert").fadeIn().css({display:'block'});	
	$("#alert script").removeAttr('style');
	setTimeout(function(){
		a.fadeOut('slow');
	}, 10000);
	setTimeout(function(){				
		a.remove();	
	}, 11000);	
	a.on('click', function(e) {
		$(this).fadeOut();
	});
}

(function($) {    
    $.LoadingDot = function(el, options) {        
        var base = this;        
        base.$el = $(el);                
        base.$el.data("LoadingDot", base);        
        base.dotItUp = function($element, maxDots) {
            if ($element.text().length == maxDots) {
                $element.text("");
            } else {
                $element.append(".");
            }
        };
        
        base.stopInterval = function() {    
            clearInterval(base.theInterval);
        };
        
        base.init = function() {
        
            if ( typeof( speed ) === "undefined" || speed === null ) speed = 300;
            if ( typeof( maxDots ) === "undefined" || maxDots === null ) maxDots = 3;            
            base.speed = speed;
            base.maxDots = maxDots;                                    
            base.options = $.extend({},$.LoadingDot.defaultOptions, options);                        
            base.$el.html("<span>" + base.options.word + "<em></em></span>");            
            base.$dots = base.$el.find("em");
            base.$loadingText = base.$el.find("span");
            
            base.$el.css("position", "relative");
            base.$dots.css({"position": "absolute"});
                          
            base.theInterval = setInterval(base.dotItUp, base.options.speed, base.$dots, base.options.maxDots);
            
        };        
        base.init();    
    };
    
    $.LoadingDot.defaultOptions = {
        speed: 300,
        maxDots: 3,
        word: "Loading"
    };
    
    $.fn.LoadingDot = function(options) {        
        if (typeof(options) == "string") {
            var safeGuard = $(this).data('LoadingDot');
			if (safeGuard) {
				safeGuard.stopInterval();
			}
        } else { 
            return this.each(function(){
                (new $.LoadingDot(this, options));
            });
        }         
    };
    
})(jQuery);
