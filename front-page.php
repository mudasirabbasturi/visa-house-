<?php
/**
 * Front page.
 *
 * @package VisaHouse
 */

get_header();

get_template_part( 'template-parts/home/hero' );
get_template_part( 'template-parts/home/services-grouped' );
get_template_part( 'template-parts/home/steps' );
get_template_part( 'template-parts/home/about' );
get_template_part( 'template-parts/home/reviews' );
get_template_part( 'template-parts/home/blog' );
get_template_part( 'template-parts/home/faq' );
get_footer();
