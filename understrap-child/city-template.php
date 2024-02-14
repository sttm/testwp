<?php
/*
Template Name: Город
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

        <section class="latest-properties">
            <h2>Последние объекты недвижимости в этом городе:</h2>
            <ul>
                <?php
                // Получаем ID текущего города
                $city_id = get_the_ID();

                // Кастомный запрос для получения последних объектов недвижимости в этом городе
                $args = array(
                    'post_type' => 'property',
                    'posts_per_page' => 10,
                    'meta_query' => array(
                        array(
                            'key' => 'property_city', // Метаполе, в которой хранится ID города
                            'value' => $city_id,
                            'compare' => '=',
                        ),
                    ),
                    'orderby' => 'date',
                    'order' => 'DESC',
                );
                $property_query = new WP_Query( $args );

                // Если есть объекты недвижимости, выводим их
                if ( $property_query->have_posts() ) :
                    while ( $property_query->have_posts() ) : $property_query->the_post();
                        ?>
                        <li>
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </li>
                        <?php
                    endwhile;
                else :
                    echo '<li>Объекты недвижимости в этом городе не найдены.</li>';
                endif;

                // Возвращаем оригинальные данные поста
                wp_reset_postdata();
                ?>
            </ul>
        </section>

    </main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();
