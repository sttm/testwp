<?php
/*
Template Name: Объект недвижимости
*/
get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">

        <?php
        // Start the loop.
        while ( have_posts() ) :
            the_post();

            // Include the page content template.
            get_template_part( 'template-parts/content', 'page' );

            // End of the loop.
        endwhile;
        ?>

        <section class="property-details">
            <h2>Детали объекта недвижимости:</h2>
            <?php
            // Получаем значения метаполей объекта недвижимости
            $area = get_post_meta( get_the_ID(), 'area', true );
            $price = get_post_meta( get_the_ID(), 'price', true );
            $address = get_post_meta( get_the_ID(), 'address', true );
            $living_area = get_post_meta( get_the_ID(), 'living_area', true );
            $floor = get_post_meta( get_the_ID(), 'floor', true );

            // Выводим значения метаполей
            if ( $area ) {
                echo '<p><strong>Площадь:</strong> ' . esc_html( $area ) . '</p>';
            }
            if ( $price ) {
                echo '<p><strong>Стоимость:</strong> ' . esc_html( $price ) . '</p>';
            }
            if ( $address ) {
                echo '<p><strong>Адрес:</strong> ' . esc_html( $address ) . '</p>';
            }
            if ( $living_area ) {
                echo '<p><strong>Жилая площадь:</strong> ' . esc_html( $living_area ) . '</p>';
            }
            if ( $floor ) {
                echo '<p><strong>Этаж:</strong> ' . esc_html( $floor ) . '</p>';
            }
            ?>
        </section>

    </main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();
