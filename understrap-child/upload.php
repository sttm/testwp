<?php
// Проверяем, был ли отправлен файл
if ($_FILES['property_image']) {
    $file = $_FILES['property_image'];

    // Проверяем, нет ли ошибок при загрузке файла
    if ($file['error'] === UPLOAD_ERR_OK) {
        // Получаем имя файла
        $filename = $file['name'];
        // Путь для сохранения файла
        $destination = 'uploads/' . $filename;

        // Перемещаем файл из временной директории в указанную
        if (move_uploaded_file($file['tmp_name'], $destination)) {
            echo 'Файл успешно загружен.';
        } else {
            echo 'Произошла ошибка при перемещении файла.';
        }
    } else {
        echo 'Произошла ошибка при загрузке файла.';
    }
} else {
    echo 'Файл не был отправлен.';
}
?>
