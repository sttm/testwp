<?php

add_action('wp_enqueue_scripts', 'enqueue_parent_styles');
function enqueue_parent_styles()
{
    wp_enqueue_style('parent-style', get_stylesheet_directory_uri() . '/style.css');
}

// Удалите стандартное метаполе для изображений
function remove_featured_image_metabox()
{
    remove_meta_box('postimagediv', 'property', 'side');
}
add_action('do_meta_boxes', 'remove_featured_image_metabox');



function custom_post_type_cities()
{
    $labels = array(
        'name'               => _x('Города', 'Post Type General Name', 'text_domain'),
        'singular_name'      => _x('Город', 'Post Type Singular Name', 'text_domain'),
        'menu_name'          => __('Города', 'text_domain'),
        'parent_item_colon'  => __('Родительский город:', 'text_domain'),
        'all_items'          => __('Все города', 'text_domain'),
        'view_item'          => __('Просмотреть город', 'text_domain'),
        'add_new_item'       => __('Добавить новый город', 'text_domain'),
        'add_new'            => __('Добавить новый', 'text_domain'),
        'edit_item'          => __('Редактировать город', 'text_domain'),
        'update_item'        => __('Обновить город', 'text_domain'),
        'search_items'       => __('Найти город', 'text_domain'),
        'not_found'          => __('Города не найдены', 'text_domain'),
        'not_found_in_trash' => __('Города не найдены в корзине', 'text_domain'),
    );
    $args = array(
        'label'               => __('Города', 'text_domain'),
        'description'         => __('Города', 'text_domain'),
        'labels'              => $labels,
        'supports'            => array('title', 'editor', 'thumbnail'),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-location-alt',
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
    );
    register_post_type('city', $args);
}
add_action('init', 'custom_post_type_cities', 0);

// Регистрация типа поста "Недвижимость"
function custom_post_type_properties()
{
    $labels = array(
        'name'               => _x('Недвижимость', 'Post Type General Name', 'text_domain'),
        'singular_name'      => _x('Недвижимость', 'Post Type Singular Name', 'text_domain'),
        'menu_name'          => __('Недвижимость', 'text_domain'),
        'parent_item_colon'  => __('Родительский объект:', 'text_domain'),
        'all_items'          => __('Все объекты', 'text_domain'),
        'view_item'          => __('Просмотреть объект', 'text_domain'),
        'add_new_item'       => __('Добавить новый объект', 'text_domain'),
        'add_new'            => __('Добавить новый', 'text_domain'),
        'edit_item'          => __('Редактировать объект', 'text_domain'),
        'update_item'        => __('Обновить объект', 'text_domain'),
        'search_items'       => __('Найти объект', 'text_domain'),
        'not_found'          => __('Объекты не найдены', 'text_domain'),
        'not_found_in_trash' => __('Объекты не найдены в корзине', 'text_domain'),
    );
    $args = array(
        'label'               => __('Недвижимость', 'text_domain'),
        'description'         => __('Недвижимость', 'text_domain'),
        'labels'              => $labels,
        'supports'            => array('title', 'editor', 'thumbnail', 'custom-fields'),
        'taxonomies'          => array('property_type'),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-admin-home',
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
    );
    register_post_type('property', $args);
    register_post_meta('property', 'gallery_images', array(
        'type' => 'gallery',
        'description' => 'Галерея изображений недвижимости',
        'single' => false,
        'show_in_rest' => true,
    ));
}
add_action('init', 'custom_post_type_properties', 0);



// Добавляем метаполя для типа поста "Недвижимость"
function add_custom_meta_boxes()
{
    add_meta_box(
        'property_details', // Идентификатор метаполя
        'Детали недвижимости', // Заголовок метаполя
        'render_property_details_meta_box', // Функция отрисовки метаполя
        'property', // Тип записи, к которой привязывается метаполе
        'normal', // Местоположение метаполя (normal, side, advanced)
        'default' // Приоритет метаполя (high, core, default, low)
    );
}

add_action('add_meta_boxes', 'add_custom_meta_boxes');
function render_property_details_meta_box($post)
{
    // Получаем сохраненные значения метаполей
    $area = get_post_meta($post->ID, 'area', true);
    $price = get_post_meta($post->ID, 'price', true);
    $address = get_post_meta($post->ID, 'address', true);
    $living_area = get_post_meta($post->ID, 'living_area', true);
    $floor = get_post_meta($post->ID, 'floor', true);
    $gallery_images = get_post_meta($post->ID, 'gallery_images', true);

    // Выводим HTML форму с полями для ввода данных
?>
    <p>
        <label for="area">Площадь:</label><br>
        <input type="text" id="area" name="area" value="<?php echo esc_attr($area); ?>">
    </p>
    <p>
        <label for="price">Стоимость:</label><br>
        <input type="text" id="price" name="price" value="<?php echo esc_attr($price); ?>">
    </p>
    <p>
        <label for="address">Адрес:</label><br>
        <input type="text" id="address" name="address" value="<?php echo esc_attr($address); ?>">
    </p>
    <p>
        <label for="living_area">Жилая площадь:</label><br>
        <input type="text" id="living_area" name="living_area" value="<?php echo esc_attr($living_area); ?>">
    </p>
    <p>
        <label for="floor">Этаж:</label><br>
        <input type="text" id="floor" name="floor" value="<?php echo esc_attr($floor); ?>">
    </p>



    <script>
        jQuery(document).ready(function($) {
            // Клик по кнопке для открытия медиа-галереи
            $('#upload_image_button').click(function() {
                var frame = wp.media({
                    title: 'Выберите изображения',
                    multiple: true,
                    library: {
                        type: 'image'
                    },
                    button: {
                        text: 'Вставить выбранные изображения'
                    }
                });

                frame.on('select', function() {
                    var attachment = frame.state().get('selection').toJSON();
                    var imageContainer = $('#image_container');
                    imageContainer.empty(); // Очищаем контейнер перед добавлением новых изображений

                    // Добавляем выбранные изображения в контейнер
                    $.each(attachment, function(index, item) {
                        imageContainer.append('<div class="image-thumbnail" data-id="' + item.id + '"><img src="' + item.sizes.thumbnail.url + '"></div>');
                    });

                    // Добавляем drag and drop функциональность
                    imageContainer.sortable({
                        update: function(event, ui) {
                            // Обновляем порядок изображений в скрытом поле
                            updateImageOrder();
                        },
                        // Указываем, что элементы можно перетаскивать
                        items: ".image-thumbnail"
                    });


                    // Обновляем скрытое поле с ID изображений
                    updateImageOrder();
                });

                frame.open();
            });
            $(document).on('click', '.remove-image', function() {
                var imageId = $(this).data('id');
                var imageContainer = $(this).closest('.image-thumbnail');

                // Удаляем изображение из списка
                imageContainer.remove();

                // Обновляем скрытое поле с ID изображений
                updateImageOrder();
            });
            // Функция для обновления порядка изображений в скрытом поле
            function updateImageOrder() {
                var imageContainer = $('#image_container');
                var imageIds = [];

                // Получаем порядок изображений и их ID
                imageContainer.find('.image-thumbnail').each(function(index, item) {
                    imageIds.push($(item).data('id'));
                });

                // Обновляем скрытое поле с ID изображений
                $('#gallery_images').val(imageIds.join(','));
            }
        });
    </script>
<?php
}



// Сохранение значений метаполей при сохранении записи
function save_property_details_meta($post_id)
{
    // Проверяем, если это автосохранение, то ничего не делаем
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Проверяем разрешения пользователя на редактирование этого поста
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Обновляем метаданные для каждого поля, если они установлены в форме
    if (isset($_POST['area'])) {
        update_post_meta($post_id, 'area', sanitize_text_field($_POST['area']));
    }
    if (isset($_POST['price'])) {
        update_post_meta($post_id, 'price', sanitize_text_field($_POST['price']));
    }
    if (isset($_POST['address'])) {
        update_post_meta($post_id, 'address', sanitize_text_field($_POST['address']));
    }
    if (isset($_POST['living_area'])) {
        update_post_meta($post_id, 'living_area', sanitize_text_field($_POST['living_area']));
    }
    if (isset($_POST['floor'])) {
        update_post_meta($post_id, 'floor', sanitize_text_field($_POST['floor']));
    }

    // Метаданные галереи изображений
    if (!empty($_FILES['gallery_images']['name'][0])) {
        $gallery_images_ids = array();
        $files = $_FILES['gallery_images'];
        $upload_overrides = array('test_form' => false);
        foreach ($files['name'] as $key => $value) {
            if ($files['name'][$key]) {
                $file = array(
                    'name'     => $files['name'][$key],
                    'type'     => $files['type'][$key],
                    'tmp_name' => $files['tmp_name'][$key],
                    'error'    => $files['error'][$key],
                    'size'     => $files['size'][$key]
                );
                $_FILES = array('gallery_images' => $file);
                $image_id = media_handle_upload('gallery_images', 0);
                if (is_wp_error($image_id)) {
                    echo 'Ошибка при загрузке изображения: ' . $image_id->get_error_message();
                    wp_die();
                }
                $gallery_images_ids[] = $image_id;
            }
        }
        update_post_meta($post_id, 'gallery_images', $gallery_images_ids);
    }
}
add_action('save_post', 'save_property_details_meta');


function add_image_gallery_meta_box()
{
    add_meta_box(
        'image_gallery',
        'Галерея изображений',
        'render_image_gallery_meta_box',
        'property', // Тип поста "Недвижимость"
        'side',
        'default'
    );
}
add_action('add_meta_boxes', 'add_image_gallery_meta_box');

function render_image_gallery_meta_box($post)
{
    $gallery_images = get_post_meta($post->ID, 'gallery_images', true);
?>
    <label for="gallery_images">Выберите изображения:</label><br>
    <input type="button" id="upload_image_button" class="button" value="Выбрать изображения">
    <input type="hidden" id="gallery_images" name="gallery_images" value="<?php echo esc_attr($gallery_images); ?>">
    <div id="image_container">
        <!-- Здесь будут отображаться миниатюры выбранных изображений -->
        <?php if (!empty($gallery_images)) : ?>
            <?php
            $image_ids = explode(',', $gallery_images);
            $first_image_id = reset($image_ids); // Получаем первый элемент из массива
            $first_image_url = wp_get_attachment_image_url($first_image_id, 'thumbnail'); // Получаем URL-адрес первой миниатюры
            ?>
            <?php
            // Проверяем, есть ли изображение для использования в качестве post_thumbnail
            if (!empty($first_image_id)) {
                // Устанавливаем первое изображение в качестве post_thumbnail
                set_post_thumbnail(get_the_ID(), $first_image_id);
            }
            ?>
            <?php foreach ($image_ids as $image_id) : ?>
                <?php $image_url = wp_get_attachment_image_url($image_id, 'thumbnail'); ?>
                <div class="image-thumbnail" data-id="<?php echo $image_id; ?>">
                    <img src="<?php echo $image_url; ?>">
                </div>
                <br> <!-- Добавьте перенос строки после каждого изображения -->
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
<?php
}

// Сохранение значений метаполей для нового метабокса
function save_image_gallery_meta($post_id)
{
    if (isset($_POST['gallery_images'])) {
        update_post_meta($post_id, 'gallery_images', sanitize_text_field($_POST['gallery_images']));
    }
}
add_action('save_post', 'save_image_gallery_meta');


// Добавляем метаполе для выбора города
function add_property_city_meta_box()
{
    add_meta_box(
        'property_city',
        'Город',
        'render_property_city_meta_box',
        'property', // Тип поста "Недвижимость"
        'side',
        'default'
    );
}
add_action('add_meta_boxes', 'add_property_city_meta_box');

function render_property_city_meta_box($post)
{
    $selected_city = get_post_meta($post->ID, 'property_city', true);
?>
    <label for="property_city">Выберите город:</label><br>
    <select name="property_city" id="property_city">
        <option value="">Выберите город</option>
        <?php
        $cities = get_posts(array(
            'post_type' => 'city',
            'posts_per_page' => -1,
        ));
        foreach ($cities as $city) {
            printf('<option value="%s" %s>%s</option>', esc_attr($city->ID), selected($selected_city, $city->ID, false), esc_html($city->post_title));
        }
        ?>
    </select>
<?php
}

function save_property_city_meta($post_id)
{
    if (isset($_POST['property_city'])) {
        update_post_meta($post_id, 'property_city', sanitize_text_field($_POST['property_city']));
    }
}
add_action('save_post', 'save_property_city_meta');

function display_property_city($content)
{
    if ('property' === get_post_type()) {
        $city_id = get_post_meta(get_the_ID(), 'property_city', true);
        if ($city_id) {
            $city = get_post($city_id);
            if ($city) {
                $content .= '<p><strong>Город:</strong> ' . esc_html($city->post_title) . '</p>';
            }
        }
    }
    return $content;
}

function custom_taxonomy_property_type()
{
    $labels = array(
        'name'              => _x('Тип недвижимости', 'taxonomy general name'),
        'singular_name'     => _x('Тип недвижимости', 'taxonomy singular name'),
        'search_items'      => __('Искать тип недвижимости'),
        'all_items'         => __('Все типы недвижимости'),
        'parent_item'       => __('Родительский тип недвижимости'),
        'parent_item_colon' => __('Родительский тип недвижимости:'),
        'edit_item'         => __('Редактировать тип недвижимости'),
        'update_item'       => __('Обновить тип недвижимости'),
        'add_new_item'      => __('Добавить новый тип недвижимости'),
        'new_item_name'     => __('Новый тип недвижимости'),
        'menu_name'         => __('Тип недвижимости'),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'property-type'),
    );

    register_taxonomy('property_type', array('property'), $args);
}
add_action('init', 'custom_taxonomy_property_type', 0);



// Кастомный запрос для получения последних объектов недвижимости
function get_latest_properties()
{
    $args = array(
        'post_type' => 'property',
        'posts_per_page' => 5, // Количество объектов для отображения
        'orderby' => 'date',
        'order' => 'DESC',
    );
    $property_query = new WP_Query($args);
    return $property_query;
}

// Кастомный запрос для получения всех городов
function get_all_cities()
{
    $args = array(
        'post_type' => 'city',
        'posts_per_page' => -1,
        'orderby' => 'title',
        'order' => 'ASC',
    );
    $city_query = new WP_Query($args);
    return $city_query;
}
add_action('wp_ajax_add_property', 'add_property_callback');
add_action('wp_ajax_nopriv_add_property', 'add_property_callback');
function add_property_callback()
{
    // Проверяем, были ли загружены изображения
    if (!empty($_FILES['property_image']['name'][0])) {
        $images_ids = array();
        $files = $_FILES['property_image'];
        $upload_overrides = array('test_form' => false);
        foreach ($files['name'] as $key => $value) {
            if ($files['name'][$key]) {
                $file = array(
                    'name'     => $files['name'][$key],
                    'type'     => $files['type'][$key],
                    'tmp_name' => $files['tmp_name'][$key],
                    'error'    => $files['error'][$key],
                    'size'     => $files['size'][$key]
                );
                $_FILES = array('property_image' => $file);
                $image_id = media_handle_upload('property_image', 0);
                if (is_wp_error($image_id)) {
                    echo 'Ошибка при загрузке изображения: ' . $image_id->get_error_message();
                    wp_die();
                }
                $images_ids[] = $image_id;
            }
        }
    }
    // Выводим содержимое $_POST массива для отладки
    echo '<pre>';
    var_dump($_POST);
    echo '</pre>';

    // Создаем новый пост для объекта недвижимости
    $property_args = array(
        'post_title'   => sanitize_text_field($_POST['property_title']),
        'post_content' => '',
        'post_status'  => 'publish',
        'post_type'    => 'property',
        'meta_input'   => array(
            'area'            => sanitize_text_field($_POST['property_area']),
            'price'           => sanitize_text_field($_POST['property_price']),
            'address'         => sanitize_text_field($_POST['property_address']),
            'living_area'     => sanitize_text_field($_POST['property_living_area']),
            'floor'           => sanitize_text_field($_POST['property_floor']),
            'city'            => sanitize_text_field($_POST['property_city']),
            'property_type'   => sanitize_text_field($_POST['property_type']),
            'property_images' => $images_ids,
        ),
    );

    // Вставляем пост и получаем его ID
    $property_id = wp_insert_post($property_args);
    // Присваиваем загруженные изображения к объекту недвижимости
    if (!empty($images_ids)) {
        foreach ($images_ids as $image_id) {
            if ($image_id && !is_wp_error($image_id)) {
                // Добавляем метаданные, указывающие, что изображение является частью галереи объекта недвижимости
                add_post_meta($property_id, 'gallery_images', $image_id);
            }
            
        }
        set_post_thumbnail($property_id, $images_ids[0]);
        // Устанавливаем галерею изображений для объекта недвижимости
        // update_post_meta($property_id, '_thumbnail_id', $images_ids[0]); // Устанавливаем первое изображение в галерее как миниатюру объекта недвижимости
        update_post_meta($property_id, 'property_images', $images_ids); // Обновляем метаданные галереи изображений объекта недвижимости
    }
    // Проверяем успешность сохранения записи
    if ($property_id) {
        // Сохраняем город и тип недвижимости как термины таксономии
        wp_set_object_terms($property_id, sanitize_text_field($_POST['property_type']), 'property_type');
    
        // Если необходимо, сохраняем остальные метаполя
        update_post_meta($property_id, 'area', sanitize_text_field($_POST['property_area']));
        update_post_meta($property_id, 'price', sanitize_text_field($_POST['property_price']));
        update_post_meta($property_id, 'address', sanitize_text_field($_POST['property_address']));
        update_post_meta($property_id, 'living_area', sanitize_text_field($_POST['property_living_area']));
        update_post_meta($property_id, 'floor', sanitize_text_field($_POST['property_floor']));
        update_post_meta($property_id, 'city', sanitize_text_field($_POST['property_city']));
    
        // Выводим сообщение об успешном добавлении объекта недвижимости
        echo 'Объект недвижимости успешно добавлен!';
    } else {
        echo 'Ошибка при добавлении объекта недвижимости';
    }


    wp_die();
}

// Добавляем колонки в таблицу управления объектами недвижимости
function custom_property_columns($columns)
{
    $columns['price'] = __('Цена', 'text_domain'); // Добавляем колонку "Цена"
    $columns['area'] = __('Площадь', 'text_domain'); // Добавляем колонку "Площадь"
    $columns['city'] = __('Город', 'text_domain'); // Добавляем колонку "Город"
    // $columns['property_type'] = __('Тип недвижимости', 'text_domain'); // Добавляем колонку "Тип недвижимости"

    return $columns;
}
add_filter('manage_property_posts_columns', 'custom_property_columns');

// Заполняем новые колонки значениями
function custom_property_column_values($column, $post_id)
{
    switch ($column) {
        case 'price':
            echo get_post_meta($post_id, 'price', true); // Выводим значение метаполя "Цена"
            break;
        case 'area':
            echo get_post_meta($post_id, 'area', true); // Выводим значение метаполя "Площадь"
            break;
        case 'city':
            $city_id = get_post_meta($post_id, 'property_city', true);
            if ($city_id) {
                $city = get_post($city_id);
                if ($city) {
                    echo esc_html($city->post_title); // Выводим название города
                }
            }
            break;
        case 'property_type':
            echo get_post_meta($post_id, 'property_type', true); // Выводим значение метаполя "Тип недвижимости"
            break;
    }
}
add_action('manage_property_posts_custom_column', 'custom_property_column_values', 10, 2);
