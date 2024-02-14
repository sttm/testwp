<?php
get_header(); ?>


<div class="container">
    <?php while (have_posts()) : ?>
        <?php the_post(); ?>
        <?php if (is_singular()) : ?>
            <div class="navigation-links">
                <div class="nav-previous"><?php previous_post_link('%link', '&laquo; Предыдущий пост'); ?></div>
                <div class="nav-next"><?php next_post_link('%link', 'Следующий пост &raquo;'); ?></div>
            </div>
        <?php endif; ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class('my-5'); ?>>
            <header class="entry-header">
                <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
            </header><!-- .entry-header -->

            <div class="entry-content">
                <?php
                // Выводим список изображений галереи
                $gallery_images = get_post_meta(get_the_ID(), 'gallery_images', true);
                //
                
                if (is_string($gallery_images)) {
                    $gallery_images_array = explode(',', $gallery_images);
                    echo '<div class="gallery">';
                    foreach ($gallery_images_array as $image_id) {
                        $modal_id = 'myModal-' . $image_id;
                        echo '<img src="' . wp_get_attachment_image_url($image_id, 'large') . '" class="gallery-image" data-modal-id="' . $modal_id . '" />';
                        echo '<div id="' . $modal_id . '" class="modal">';
                        echo '<span class="close">&times;</span>';
                        echo '<img class="modal-content" />';
                        echo '</div>';
                    }
                    echo '</div>';
                   
                } else {
                    echo '<div class="gallery">';
                    foreach ($gallery_images as $image_id) {
                        $modal_id = 'myModal-' . $image_id;
                        echo '<img src="' . wp_get_attachment_image_url($image_id, 'large') . '" class="gallery-image" data-modal-id="' . $modal_id . '" />';
                        echo '<div id="' . $modal_id . '" class="modal">';
                        echo '<span class="close">&times;</span>';
                        echo '<img class="modal-content" />';
                        echo '</div>';
                    }
                    echo '</div>';
                  
                }
                ?>

                <?php the_content(); ?>

                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Площадь:</strong> <?php echo esc_html(get_post_meta(get_the_ID(), 'area', true)); ?></p>
                        <p><strong>Стоимость:</strong> <?php echo esc_html(get_post_meta(get_the_ID(), 'price', true)); ?></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Адрес:</strong> <?php echo esc_html(get_post_meta(get_the_ID(), 'address', true)); ?></p>
                        <p><strong>Жилая площадь:</strong> <?php echo esc_html(get_post_meta(get_the_ID(), 'living_area', true)); ?></p>
                        <p><strong>Этаж:</strong> <?php echo esc_html(get_post_meta(get_the_ID(), 'floor', true)); ?></p>
                    </div>
                </div>

                <?php
                // Вывод информации о городе
                $city_id = get_post_meta(get_the_ID(), 'property_city', true);
                if ($city_id) {
                    $city = get_post($city_id);
                    if ($city) {
                        echo '<p><strong>Город:</strong> ' . esc_html($city->post_title) . '</p>';
                    }
                }
                ?>
            </div><!-- .entry-content -->

            <footer class="entry-footer">
                <?php
                edit_post_link(
                    sprintf(
                        esc_html__('Edit %s', 'your-theme'),
                        '<span class="screen-reader-text">' . get_the_title() . '</span>'
                    ),
                    '<span class="edit-link">',
                    '</span>'
                );
                ?>
            </footer><!-- .entry-footer -->
        </article><!-- #post-<?php the_ID(); ?> -->

        <?php if (!is_singular()) : ?>
            <hr class="my-5"> <!-- Горизонтальная линия между постами -->
        <?php endif; ?>



    <?php endwhile; ?>
</div>
<script>
    jQuery(document).ready(function($) {
        // При клике на изображение галереи
        $('.gallery-image').on('click', function() {
            // Получаем URL изображения
            var imageUrl = $(this).attr('src');
            var modalId = $(this).data('modal-id');

            // Отображаем модальное окно с изображением
            $('#' + modalId).css('display', 'block');
            $('#' + modalId + ' .modal-content').attr('src', imageUrl);
        });

        // При клике на кнопку закрытия модального окна
        $('.close').on('click', function() {
            $('.modal').css('display', 'none'); // Скрываем все модальные окна
        });
    });
</script>
<?php get_footer(); ?>