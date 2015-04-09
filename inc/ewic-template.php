<?php


/*-------------------------------------------------------------------------------*/
/*   Generate Slider
/*-------------------------------------------------------------------------------*/	
function ewic_generate_slider( $id, $iswidget ) {
	ob_start();
	
	$allimgs = get_post_meta( $id, 'ewic_meta_select_images', true );
	$imgsize = get_post_meta( $id, 'ewic_meta_thumbsizelt', true );
	$easing = get_post_meta( $id, 'ewic_meta_settings_effect', true );
	( get_post_meta( $id, 'ewic_meta_slide_auto', true ) == 'on' ) ? $disenauto = 'true' : $disenauto = 'false';
	( get_post_meta( $id, 'ewic_meta_slide_title', true ) == 'on' ) ? $disenttl = 'true' : $disenttl = 'false';
	( get_post_meta( $id, 'ewic_meta_slide_lightbox_autoslide', true ) == 'on' ) ? $disenlbauto = 'true' : $disenlbauto = 'false';
	
	if ( is_array( $imgsize ) ) {
		
		if ( $imgsize['width'] == 'auto' ) {
			$sw = '0';
		} else {
			$sw = $imgsize['width'];
			}
			
		if ( $imgsize['height'] == 'auto' ) {
			$autoheight = 'true';
		} else {
			$autoheight = 'false';

			echo '<style>#ewic-con'.$iswidget.'-'.$id.' .bx-wrapper, #ewic-con'.$iswidget.'-'.$id.' .bx-viewport, #ewic-con'.$iswidget.'-'.$id.' .bx-wrapper img { max-height: '.$imgsize['height'].'px;}</style>';
			}
			
	} else {
		$autoheight = 'true';
		$sw = '0';
	}
	
	if ( is_array( $allimgs ) ) {
	//Generate HTML Markup	
	echo '<div id="preloader'.$iswidget.'-'.$id.'" class="sliderpreloader"></div>';
	echo '<ul style="display:none;" class="bxslider'.$iswidget.'-'.$id.'">';
		foreach( $allimgs as $dat ) {
			$img = wp_get_attachment_image_src( $dat['images'], 'full' );
			if ( $dat['ttl'] ) {
				$isttl = 'title="'.$dat['ttl'].'"';
				}
				else {
					$isttl = '';
					}
			if (get_post_meta( $id, 'ewic_meta_slide_lightbox', true ) == 'on' ) {
				echo'<li class="ewic-slider"><a href="'.$img[0].'" title="'.$dat['ttl'].'" rel="ewic'.$iswidget.'prettyPhoto['.$id.']"><img '.$isttl.' class="ewic-wid-imgs" src="'.$img[0].'" /></a></li>';
				
				} else {
					echo'<li class="ewic-slider"><img '.$isttl.' class="ewic-wid-imgs" src="'.$img[0].'" /></li>';
					}
					
			}
	echo '</ul><br>';		
			
			
	//Generate Slider Script				
	echo '<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery("#preloader'.$iswidget.'-'.$id.'").fadeOut(2000, function () {
		jQuery(".bxslider'.$iswidget.'-'.$id.'").fadeIn(3000);
		jQuery(".bxslider'.$iswidget.'-'.$id.'").bxSlider({
			slideWidth: '.$sw.',
			slideMargin: 10,
			minSlides: 1,
			pager: false,
			useCSS: false,
			easing: "'.$easing.'",
			auto: '.$disenauto.',
			autoControls: true,
			stopAuto: false,
			speed: 2000,
			pause: '.get_post_meta( $id, 'ewic_meta_slide_delay', true ).'000,
			adaptiveHeight: '.$autoheight.',
			adaptiveHeightSpeed: 700,
			controls: true,
			preloadImages: "visible",
			infiniteLoop: true,
			captions: '.$disenttl.',
			autoHover: true,
			mode: "'.get_post_meta( $id, 'ewic_meta_slide_style', true ).'",
			onSlideBefore:  function() {
				jQuery(".bxslider'.$iswidget.'-'.$id.' .bx-caption").slideUp();
            },
			onSlideAfter: function() {
				jQuery("."+jQuery(".bxslider'.$iswidget.'-'.$id.'").parent().next().find(".bx-controls-auto").find("a").attr("class")).trigger("click");
				jQuery(".bxslider'.$iswidget.'-'.$id.' .bx-caption").slideDown();
            }
			
			});
			
			jQuery(".bx-clone a").removeAttr( "rel" );
			
			'.( ( get_post_meta( $id, 'ewic_meta_slide_nav', true ) != 'always' ) ? 'jQuery( ".bxslider'.$iswidget.'-'.$id.'" ).parent().parent().addClass( "navcontroller" );' : '' ).'

			
	jQuery("a[rel^=\'ewic'.$iswidget.'prettyPhoto['.$id.']\']").ewcPhoto({theme: "ewc_default", allow_expand: false, deeplinking: false, slideshow:'.get_post_meta( $id, 'ewic_meta_slide_lightbox_delay', true ).'000, autoplay_slideshow:'.$disenlbauto.', social_tools:false});
				
		});
	});
</script>';
		}
		
		$res = ob_get_clean();
		return $res;	
		
}


?>