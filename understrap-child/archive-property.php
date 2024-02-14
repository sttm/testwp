<?php


get_header();
?>

<main id="primary" class="site-main">
    <header class="page-header">
        <h1 class="page-title"><?php post_type_archive_title(); ?></h1>
    </header><!-- .page-header -->

    <section class="latest-properties">
            <?php
            // Кастомный запрос для получения последних объектов недвижимости
            $args = array(
                'post_type'      => 'property',
                'posts_per_page' => 10, // Количество объектов для отображения
                'orderby'        => 'date',
                'order'          => 'DESC',
            );
            $property_query = new WP_Query( $args );

            // Выводим объекты недвижимости
            if ( $property_query->have_posts() ) :
                while ( $property_query->have_posts() ) :
                    $property_query->the_post();
                    ?>
                    <article>
                        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <a href="<?php the_permalink(); ?>">
                        <?php
                        // Выводим картинку объекта недвижимости
                        if ( has_post_thumbnail() ) {
                            the_post_thumbnail( 'medium' );
                        }
                        ?>
                        </a>
                        <p><strong>Площадь:</strong> <?php echo get_post_meta( get_the_ID(), 'area', true ); ?></p>
                        <p><strong>Стоимость:</strong> <?php echo get_post_meta( get_the_ID(), 'price', true ); ?></p>
                        <p><strong>Адрес:</strong> <?php echo get_post_meta( get_the_ID(), 'address', true ); ?></p>
                        <p><strong>Жилая площадь:</strong> <?php echo get_post_meta( get_the_ID(), 'living_area', true ); ?></p>
                        <p><strong>Этаж:</strong> <?php echo get_post_meta( get_the_ID(), 'floor', true ); ?></p>
                        
                        <div id="btn_excerpt">
                            <?php the_excerpt(); ?>
                        </div>

                        <script>
                            jQuery(document).ready(function($) {
                                // Находим ссылку внутри элемента с id="btn_excerpt" и заменяем текст
                                $('#btn_excerpt a').text('Подробнее');
                            });
                        </script>
                    </article>
                    <?php
                endwhile;
                wp_reset_postdata();
            else :
                echo 'Нет последних объектов недвижимости.';
            endif;
            ?>
        </section>

</main><!-- #primary -->

<?php
get_footer();
