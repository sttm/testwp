<?php get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">

        <?php
        // Start the Loop.
        while ( have_posts() ) :
            the_post();

            // Include the page content template.
            get_template_part( 'template-parts/content', 'page' );

            // Получаем ID текущего города
            $city_id = get_the_ID();

            // Кастомный запрос для получения связанных объектов недвижимости
            $args = array(
                'post_type' => 'property',
                'posts_per_page' => -1, // Получить все объекты недвижимости для этого города
                'meta_query' => array(
                    array(
                        'key' => 'property_city', // Метаполе для связи с городом
                        'value' => $city_id,
                        'compare' => '=',
                    ),
                ),
            );
            $property_query = new WP_Query( $args );

            // Проверяем, есть ли записи недвижимости
            if ( $property_query->have_posts() ) :
                echo '<h2>Объекты недвижимости в этом городе:</h2>';
                echo '<ul>';
                while ( $property_query->have_posts() ) : $property_query->the_post();
                    // Отображаем заголовок объекта недвижимости как ссылку на его страницу
                    echo '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
                endwhile;
                echo '</ul>';
                // Восстанавливаем оригинальные данные поста
                wp_reset_postdata();
            else :
                echo '<p>В этом городе нет доступной недвижимости.</p>';
            endif;

        endwhile; // End the loop.
        ?>

    </main><!-- #main -->
</div><!-- #primary -->

<?php get_footer(); ?>
