<?php
while ( have_posts() ) : the_post();

    ?><article id="post-<?php the_ID(); ?>" <?php post_class(); ?>><?php
    the_content();
    wp_link_pages( array(
        'before'      => '<div class="page-links">' . esc_html__( 'Pages:', 'kava' ),
        'after'       => '</div>',
        'link_before' => '<span>',
        'link_after'  => '</span>',
    ) );
    ?></article><!-- #post-<?php the_ID(); ?> --><?php

endwhile; // End of the loop.