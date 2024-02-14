<form id="add-property-form" enctype="multipart/form-data" class="container mt-5" action="<?php echo admin_url('admin-ajax.php'); ?>" method="POST">
    <div class="form-group">
        <input type="text" name="property_title" class="form-control" placeholder="Название объекта" required>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <input type="text" name="property_area" class="form-control" placeholder="Площадь" required>
        </div>
        <div class="form-group col-md-6">
            <input type="text" name="property_price" class="form-control" placeholder="Стоимость" required>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <input type="text" name="property_floor" class="form-control" placeholder="Этаж" required>

        </div>
        <div class="form-group col-md-6">
            <input type="text" name="property_living_area" class="form-control" placeholder="Жилая площадь" required>
        </div>

    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <select name="property_city" class="form-control" required>
                <option value="" disabled selected>Выберите город</option>
                <?php
                $cities = get_posts(array(
                    'post_type' => 'city', // Укажите ваш пост-тип
                    'posts_per_page' => -1,
                    'orderby' => 'title',
                    'order' => 'ASC'
                ));


                foreach ($cities as $city) {

                ?>
                    <option value="<?php echo esc_attr($city->ID); ?>"><?php echo esc_html($city->post_title); ?></option>
                <?php
                }
                ?>
            </select>
        </div>
        <div class="form-group col-md-6">
            <select name="property_type" class="form-control" required>
                <option value="" disabled selected>Выберите тип</option>
                <?php
                $types = get_terms(array(
                    'taxonomy' => 'property_type', // Укажите вашу таксономию
                    'hide_empty' => false, // Указывает, следует ли скрывать пустые категории
                    'orderby' => 'name', // Сортировка по названию
                    'order' => 'ASC' // Порядок сортировки (возрастание)
                ));
                foreach ($types as $type) {
                    // Выводим свойства объекта $type в консоль
                    // echo "<script>console.log('Debug Objects: " . json_encode($type->name) . "' );</script>";
                ?>
                    <option value="<?php echo esc_attr($type->name); ?>"><?php echo esc_html($type->name); ?></option>
                <?php
                }
                ?>
            </select>
        </div>


    </div>
    <div class="form-group">
        <input type="text" name="property_address" class="form-control" placeholder="Адрес" required>
    </div>
    <div class="form-group">
        <input type="file" name="property_image[]" class="form-control-file" accept="image/*" required multiple>
    </div>
    <input type="hidden" name="action" value="add_property"> <!-- Указываем действие для AJAX запроса -->
    <input type="submit" name="submit" id="submit" class="button button-primary" value="Сохранить" />
</form>

<div id="add-property-response" class="container mt-3"></div>

<script>
    jQuery(document).ready(function($) {
        $('#add-property-form').submit(function(e) {
            e.preventDefault();

            var form_data = new FormData($(this)[0]); // Используем объект FormData для сериализации данных формы

            $.ajax({
                type: 'POST',
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                data: form_data,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#add-property-response').html(response);
                },
                error: function(xhr, status, error) {
                    console.error('Ошибка при отправке запроса:', error); // Выводим ошибку в консоль
                    $('#add-property-response').html('Ошибка при отправке запроса. Пожалуйста, попробуйте снова.');
                }
            });


        });
    });
</script>