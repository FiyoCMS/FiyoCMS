$(function() {
	$(document).on('focusin', '.field, textarea', function() {
		if(this.title==this.value) {
			this.value = '';
		}
	}).on('focusout', '.field, textarea', function(){
		if(this.value=='') {
			this.value = this.title;
		}
	});

	$('.main .col:last, .main .entry:last, .footer-nav ul li:last').addClass('last');
	$('.main .cols .col ul li:first-child, #navigation ul li:first-child').addClass('first');
	$('.main .cols .col ul li:odd').addClass('odd');

	// mobile-navigation
	$('#navigation a.nav-btn').click(function(){
		$(this).toggleClass('active');
		$(this).parent().find('ul').slideToggle();
	})
});

$(window).load(function(){ 

	//slider thumb
	$('.slider ul').carouFredSel({
		align: 'center',
		circular: true,
		auto: false,
		items: {
			visible: 1,
		},
		prev: '.prev-arr',
		next: '.next-arr'
	});

	$('#thumbs').carouFredSel({
		align: false,
		scroll: {
			items: 1,
		},
		items: {
			visible: 4,
		},
		auto: false,
		infinite: true,
		prev: '#prev',
		next: '#next'
	});

	$('#thumbs a').click(function() {
		$('.slider ul').trigger('slideTo', '#' +this.href.split('#').pop());
		$('#thumbs a.selected').removeClass('selected');
		$(this).addClass('selected');
		return false;
	});

});

$(window).resize(function() { 
	carosel();
})

function carosel(){
	//slider thumb
	$('.slider ul').carouFredSel({
		align: 'center',
		circular: true,
		auto: false,
		items: {
			visible: 1,
		},
		prev: '.prev-arr',
		next: '.next-arr'
	});

	$('#thumbs').carouFredSel({
		align: false,
		scroll: {
			items: 1,
		},
		items: {
			visible: 4,
		},
		auto: false,
		infinite: true,
		prev: '#prev',
		next: '#next'
	});

	$('#thumbs a').click(function() {
		$('.slider ul').trigger('slideTo', '#' +this.href.split('#').pop());
		$('#thumbs a.selected').removeClass('selected');
		$(this).addClass('selected');
		return false;
	});
}