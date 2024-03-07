
<!-- =========================
     Page Breadcrumb   
     ============================== -->
<?php get_header(); ?>
<main id="content" class="single-class">
  <div class="container"> 
    <!--row-->
    <div class="row">
      <!--==================== breadcrumb section ====================-->
      <?php do_action('blogus_breadcrumb_content'); ?>
      <!--col-lg-->
      <?php $blogus_single_page_layout = get_theme_mod('blogus_single_page_layout','single-align-content-right');
      if($blogus_single_page_layout == "single-align-content-left") { ?>
        <aside class="col-lg-3">
          <?php get_sidebar();?>
        </aside>
      <?php } 
      if($blogus_single_page_layout == "single-align-content-right"){ ?>
        <div class="col-lg-9">
      <?php } elseif($blogus_single_page_layout == "single-align-content-left") { ?>
        <div class="col-lg-9">
      <?php } elseif($blogus_single_page_layout == "single-full-width-content") { ?>
        <div class="col-lg-12">
      <?php } 
        if(have_posts()) {
          while(have_posts()) { the_post(); ?>
            <div class="bs-blog-post single"> 
              <div class="bs-header">
                <?php 
                $tags = get_the_tags();
                $blogus_single_post_category = esc_attr(get_theme_mod('blogus_single_post_category','true'));
                  if($blogus_single_post_category == true){ ?>
                     <?php blogus_post_categories(); ?>
                <?php } ?>
                 <h1 class="title"> <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute( array('before' => esc_html_e('Permalink to: ','blogus'),'after'  => '') ); ?>">
                  <?php the_title(); ?></a>
                </h1>
              </div>
              <?php
              $single_show_featured_image = esc_attr(get_theme_mod('single_show_featured_image','true'));
              if($single_show_featured_image == true) {
              if(has_post_thumbnail()){
              echo '<a class="bs-blog-thumb" href="'.esc_url(get_the_permalink()).'">';
              the_post_thumbnail( '', array( 'class'=>'img-fluid' ) );
              echo '</a>';
                
              $thumbnail_id = get_post_thumbnail_id();
              $caption = get_post($thumbnail_id)->post_excerpt;

              if (!empty($caption)) {
                echo '<span class="featured-image-caption">' . esc_html($caption) . '</span>';
              }
               } }?>
              <article class="small single">
                <?php the_content(); ?>

                <?php
                    $isbn = get_field( 'isbn', $post->ID);

                    $book_genre = get_the_terms( $post->ID, 'book_genre' );


                    $book_results = get_transient( 'book_results_' . $post->ID );

                    if ( false === $book_results ) {
                        $book_results = wp_remote_get( 'https://www.googleapis.com/books/v1/volumes?q=isbn:' . $isbn);
                        set_transient( 'book_results_' . $post->ID, $book_results, DAY_IN_SECONDS );
                    }
            
                    if( 200 === wp_remote_retrieve_response_code( $book_results ) ) {
                        $book_results = json_decode( wp_remote_retrieve_body( $book_results ) );
                        $books = $book_results->items;

                        foreach( $books as $book ){
                ?>
                <div class="wrapper-books--container"> 
                <div class="img-wrapper">
                    <img src="<?php echo $book->volumeInfo->imageLinks->thumbnail; ?>" alt=""/>
                </div>
                <div class="info-wrapper">       
                    <p><?php echo 'Автор: ' . $book->volumeInfo->authors[0]; ?></p>

                    <p><?php echo 'Издательство: ' . $book->volumeInfo->publisher; ?></p>

                    <p><?php echo 'Год: ' . $book->volumeInfo->publishedDate; ?></p>

                    <p><?php echo 'Жанр: ' . $book_genre[0]->name; ?></p>

                    <p>ISBN: <?php the_field('isbn'); ?></p>
                </div>
            </div>
            
            <?php
                    }   
                }
            ?>

              </article>

            </div>
          <?php } ?>

            <div class="reviews bs-card-box p-4">
                <?php if( have_rows('reviews') ):?>
                  <h2>Отзывы</h2>
                    <?php while ( have_rows('reviews') ) : the_row(); ?>
                      <h3><?php  the_sub_field('name_author'); ?></h3>
                      <p><?php  the_sub_field('data_review'); ?></p>
                      <p><?php  the_sub_field('text_review'); ?></p>
                      <?php  endwhile; ?>
                    <?php  else : ?>
                <?php  endif; ?>
              </div>

           <?php $blogus_enable_single_admin_details = esc_attr(get_theme_mod('blogus_enable_single_admin_details','true'));
            if($blogus_enable_single_admin_details == true) { ?>
             <?php } ?>
            <?php $blogus_enable_related_post = esc_attr(get_theme_mod('blogus_enable_related_post','true'));
                  $blogus_enable_single_post_category = get_theme_mod('blogus_enable_single_post_category','true');
                  $blogus_enable_single_post_date = get_theme_mod('blogus_enable_single_post_date','true');
                                if($blogus_enable_related_post == true){
                            ?>
                    <!--End bs-realated-slider -->
                  <?php } } $blogus_enable_single_post_comments = esc_attr(get_theme_mod('blogus_enable_single_post_comments',true));
                  if($blogus_enable_single_post_comments == true) {
                  if (comments_open() || get_comments_number()) :
                  comments_template();
                  endif; } ?>
      </div>
       <?php if($blogus_single_page_layout == "single-align-content-right") { ?>
      <!--sidebar-->
          <!--col-lg-3-->
            <aside class="col-lg-3">
                  <?php get_sidebar();?>
            </aside>
          <!--/col-lg-3-->
      <!--/sidebar-->
      <?php } ?>
    </div>
    <!--/row-->
  </div>
  <!--/container-->
</main> 
<?php get_footer();