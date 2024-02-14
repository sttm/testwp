<?php get_header();

function debug_to_console($data)
{
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}


?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">

        <h2 id="latest-properties-h2">Последние объекты недвижимости</h2>
        <section class="latest-properties">
            <?php
            // Кастомный запрос для получения последних объектов недвижимости
            $args = array(
                'post_type'      => 'property',
                'posts_per_page' => 10, // Количество объектов для отображения
                'orderby'        => 'date',
                'order'          => 'DESC',
            );
            $property_query = new WP_Query($args);

            // Выводим объекты недвижимости
            if ($property_query->have_posts()) :
                while ($property_query->have_posts()) :
                    $property_query->the_post();
            ?>
                    <article>
                        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <a href="<?php the_permalink(); ?>">
                            <?php
                            // Выводим картинку объекта недвижимости
                            if (has_post_thumbnail()) {
                                the_post_thumbnail('medium');
                            }
                            ?>
                        </a>
                        <p><strong>Город:</strong> <?php echo get_the_title(get_post_meta(get_the_ID(), 'property_city', true)); ?></p>

                        <p><strong>Площадь:</strong> <?php echo get_post_meta(get_the_ID(), 'area', true); ?></p>
                        <p><strong>Стоимость:</strong> <?php echo get_post_meta(get_the_ID(), 'price', true); ?></p>
                        <p><strong>Адрес:</strong> <?php echo get_post_meta(get_the_ID(), 'address', true); ?></p>
                        <p><strong>Жилая площадь:</strong> <?php echo get_post_meta(get_the_ID(), 'living_area', true); ?></p>
                        <p><strong>Этаж:</strong> <?php echo get_post_meta(get_the_ID(), 'floor', true); ?></p>

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

        <h2 id="latest-cities-h2">Последние города</h2>
        <section class="latest-cities">
            <?php
            // Кастомный запрос для получения всех городов
            $args = array(
                'post_type'      => 'city',
                'posts_per_page' => 5, // Количество городов для отображения
                'orderby'        => 'date',
                'order'          => 'DESC',
            );
            $city_query = new WP_Query($args);

            // Выводим города
            if ($city_query->have_posts()) :
                while ($city_query->have_posts()) :
                    $city_query->the_post();
            ?>
                    <article>
                        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

                    </article>
            <?php
                endwhile;
                wp_reset_postdata();
            else :
                echo 'Нет последних городов.';
            endif;
            ?>
        </section>
        <?php get_template_part('add-property-form'); ?>


    </main><!-- #main -->
</div><!-- #primary -->

<?php get_footer(); ?>