/* ——— Mini Timer Plugin for jQuery ——— */
(function($){
	$.fn.startTimer = function(interval, callback){
		this.each(function(){
			$(this).data('__timer', setTimeout(callback, interval))
		});
	
		return this;
	};
	
	$.fn.stopTimer = function(){
		this.each(function(){
			timer = $(this).data('__timer');
			
			if(timer != undefined){
				clearTimeout(timer);
			}
		});
	
		return this;
	};
})(jQuery);

$(document).ready(function(){
	$('#slideshow').cycle({ 
		fx: 'scrollUp', 
		speed:    1500,
		pause: 1,
		timeout: 5000
	});
});


$(document).ready(function(e){
	/* ——— Menu Item ——— */
	$('.menu .item').click(function(e){
    	$(this).addClass('item-open item-opens');  
    });
	$(document).click(function(e){
		$('.menu .item:not(.item-opens)').removeClass('item-open');
		$('.menu .item-opens').removeClass('item-opens');
    });
	
	
	/* ——— Search ——— */
 	$('.search').hover(function(e){
		var self = this;
		
		$(this).startTimer(400, function(){
			$(self).addClass('search-open');
			$('.search-input', self).focus();	
		});
	}, function(){
		$(this).stopTimer();
	});
	$('.search').click(function(e){
		$(this).addClass('search-click');
    });
	$(document).click(function(e){
    	$('.search:not(.search-click)').removeClass('search-open');
		$('.search.search-click').removeClass('search-click');
    });
	
	
	/* ——— Cart ——— */
	$('.cart').hover(function(e){
		$('.cart').addClass('cart-hover');
	}, function(e){
		$('.cart').removeClass('cart-hover');
	});
	$('.cart').click(function(e){
    	$(this).addClass('cart-open cart-click');
		$('.cart-drop', this).fadeIn(300);   
    });
	$(document).click(function(e){
		$('.cart:not(.cart-click)').removeClass('cart-open').find('.cart-drop').fadeOut(300);
		$('.cart.cart-click').removeClass('cart-click'); 
    });
	
	
	/* ——— Navigation ——— */
	$('.nav-item').hover(function(){
		var self = $(this);
		
		self.startTimer(300, function(){
			//self.find('.nav-item-drop').stop(true, true).fadeIn(200);
			self.find('.nav-item-drop').show();
			var maxWidth = $('.nav').outerWidth();
			var itemDropWidth = self.find('.nav-item-drop').outerWidth();
			var itemLeft = self.position().left - $('.nav-item:first').position().left;
			var itemDropLeft = itemLeft;
			
			if(itemDropWidth > maxWidth){
				itemDropWidth = maxWidth;
				self.find('.nav-item-drop').width(itemDropWidth);
			}
			
			if(itemLeft + itemDropWidth > maxWidth){
				if(itemLeft + self.outerWidth() - self.find('.nav-item-drop').width() > 0){
					itemDropLeft = itemLeft + self.outerWidth() - self.find('.nav-item-drop').width();	
				}else{
					itemDropLeft = maxWidth - itemDropWidth;
				}
			}
			
			self.find('.nav-item-drop').css('left', itemDropLeft);
		});
	}, function(){
		$(this).stopTimer();
		$('.nav-item-drop', this).hide();
		//$('.nav-item-drop', this).stop().fadeOut(200);	
	});
	
	
	
	
	
	
	$('.nav-products').each(function(index, wrap){
    	$('.nav-products-list a', wrap).each(function(index, product){
         	$(product).mouseover(function(e){
				e.stopPropagation();
				
				$('.nav-products-list .nav-products-select', wrap).removeClass('nav-products-select');
				$(product).addClass('nav-products-select');

             	$('.nav-products-detail span', wrap).text($(product).data('product-name'));
				
				if($(product).data('product-new') != undefined){
					$('.nav-products-detail-price', wrap).html(
						'<span class="product-price-last">' + $(product).data('product-price') +
						'</span> <span class="product-price-new">' + $(product).data('product-new') + '</span>'
					);	
				} else {
					$('.nav-products-detail-price', wrap).text($(product).data('product-price'));	
				}
				
				$('.nav-products-detail img', wrap).attr('src', 'images/rating-' + $(product).data('product-rating') + '-small.png');
            });   
        });
		
		$('.nav-products-list a:first', wrap).trigger('mouseover');
    });
	
	$('.slider-standart').each(function(index, element) {
		var Slide = $(element);
		
		Slide.find('> *').each(function(index, element) {
           	if(index % 2 == 0){
				$(element).click(function(){
					if(Slide.find('.selected').is($(this))){
						Slide.find('.selected').removeClass('selected').next().stop(true, false).slideUp(400);	
					} else {
						Slide.find('.selected').removeClass('selected').next().stop(true, false).slideUp(400);	
						
						$(this).addClass('selected');
						$(this).next().stop(true, false).slideDown(400);		
					}
				});	
			} 
        });
    });
});