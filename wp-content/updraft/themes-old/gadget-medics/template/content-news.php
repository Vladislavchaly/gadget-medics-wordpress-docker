
<div class="news-block__item" id="post-id-<?php the_id(); ?>">
    <a href="<?php the_permalink();?>" class="news-block__link">
        <span class="news-block__img">
            <img src="<?php the_post_thumbnail_url();?>" alt="">
        </span>
        <div class="news-block__txt">
            <small>Tag name</small>
            <span class="h4"><?php the_title(); ?></span>
            <p><?php the_excerpt(''); ?></p>
        </div>
    </a>
</div>
