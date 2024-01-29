<?php
/**
 * The template for displaying post social share links
 *
 * @package Aheto
 */
 
?>

<div class="aht-page__socials">

	<div class="aht-page__socials__share text-center">
		<a class="aht-page__socials__share__link" href="#" data-share="http://www.facebook.com/sharer.php?u=<?php echo get_the_permalink(); ?>&amp;t=<?php echo get_the_title(); ?>" target="_blank">
			<i class="aht-page__socials__share__icon icon ion-social-facebook"></i>
		</a>
		<a class="aht-page__socials__share__link" href="#" data-share="http://twitter.com/home?status=<?php echo get_the_title(); ?><?php echo get_the_permalink();?>" target="_blank">
			<i class="aht-page__socials__share__icon icon ion-social-twitter"></i>
		</a>
		<a class="aht-page__socials__share__link" href="#" data-share="http://linkedin.com/shareArticle?mini=true&amp;url=<?php echo  get_the_permalink(); ?>&amp;title=<?php echo get_the_title(); ?>" target="_blank">
			<i class="aht-page__socials__share__icon icon ion-social-linkedin"></i>
		</a>
	</div>

</div>

