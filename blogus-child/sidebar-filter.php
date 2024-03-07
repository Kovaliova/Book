<div class="filter-wrapper">
    <?php 
        echo '<form action="" method="POST" id="filter">';

        if( $terms = get_terms( array( 'taxonomy' => 'book_genre' ) ) ) {

            echo '<select name="gener-filter"><option>Choose genre...</option>';
            
            foreach ( $terms as $term ) {
                echo '<option value="' . $term->slug . '">' . $term->name . '</option>';
            }
            echo '</select>';
        }   
        echo '<button>Apply filter</button><input type="hidden" name="action" value="myfilter">
        </form>';

    ?>
    <div id="resetBtn" class="reset-btn">Reset</div>
</div>