<form role="search" method="get" id="search" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="search-form">
    <label>
        <input type="search" class="search-field" placeholder="<?php esc_attr_e( 'Search...', 'ecademy' ); ?>" value="<?php echo get_search_query(); ?>" name="s" id="s" required>
    </label>
    <button type="submit"><i class="bx bx-search-alt"></i></button>
</form>