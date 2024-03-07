<?php
/**
 * The template for displaying the content.
 * @package Blogus
 */

    $my_books = get_posts( array(
        'post_type'   => 'book', 
    ));
?>
<div class="row">

    <div class="wrapper-books">
        <?php
            foreach ( $my_books as $my_book) {

                $isbn = get_field( 'isbn', $my_book->ID );

                $book_genre = get_the_terms( $my_book->ID, 'book_genre' );

                $book_results = get_transient( 'book_results_' . $my_book->ID );

                if ( false === $book_results ) {
                    $book_results = wp_remote_get( 'https://www.googleapis.com/books/v1/volumes?q=isbn:' . $isbn);
                    set_transient( 'book_results_' . $my_book->ID, $book_results, DAY_IN_SECONDS );
                }
            
                if( 200 === wp_remote_retrieve_response_code( $book_results ) ) {
                    $book_results = json_decode( wp_remote_retrieve_body( $book_results ) );
                    $books = $book_results->items;

                    foreach( $books as $book ){
         ?>
            <div class="wrapper-books--container bs-blog-post list-blog"> 
                <div class="img-wrapper">
                    <img src="<?php echo $book->volumeInfo->imageLinks->thumbnail; ?>" alt=""/>
                </div>
                <div class="info-wrapper">       
                    <h3><?php echo $book->volumeInfo->title; ?></h3>

                    <p><?php echo 'Автор: ' . $book->volumeInfo->authors[0]; ?></p>

                    <p><?php echo 'Издательство: ' . $book->volumeInfo->publisher; ?></p>

                    <p><?php echo 'Год: ' . $book->volumeInfo->publishedDate; ?></p>

                    <p><?php echo 'Жанр: ' . $book_genre[0]->name; ?></p>
                </div>
            </div>
            
        <?php
                    }   
                }
            }
      
        ?>
    </div>

    <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php while(have_posts()){ the_post(); ?>
    <!--col-md-12-->
    <div class="col-md-12 fadeInDown wow" data-wow-delay="0.1s">
        <!-- bs-posts-sec-inner -->  
        <div class="bs-blog-post list-blog">
                    <?php  
                    $url = blogus_get_freatured_image_url($post->ID, 'blogus-medium');
                    blogus_post_image_display_type($post); 
                    ?>
            <article class="small col text-xs">
              <?php 
                    $blogus_global_category_enable = get_theme_mod('blogus_global_category_enable','true');
                    if($blogus_global_category_enable == 'true') { ?>
                        <?php blogus_post_categories(); ?>
                    <?php } ?>
                    <h4 class="title"><a href="<?php the_permalink();?>"><?php the_title();?></a></h4>
                    <?php blogus_post_meta();
                        blogus_posted_content(); ?>
            </article>
          </div>
    <!-- // bs-posts-sec block_6 -->
    </div>
    <?php }
        blogus_page_pagination(); ?>
</div>
</div>