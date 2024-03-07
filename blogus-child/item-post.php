<?php
  $my_books = get_posts( array(
    'book_genre'  => $_POST['gener-filter'],
    'post_type'   => 'book',
  ));
  
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