// // Обработчик отправки формы
// $('form[name="inputForm"]').submit(function(event) {
//     // Отменяем стандартное поведение
//     event.preventDefault();
    
//     // Получаем данные формы
//     var formData = $(this).serialize();
    
//     // Получаем значение поля ввода
//     var userMessage = $('#user_message').val();
    
//     // Получаем значение выбранного языка перевода
//     var lang = $('#lang').val();
    
//     // Добавляем значение из value в конец строки
//     var additionalText = (lang == 'rus' ? ' переведи на русский ' : ' переведи на узбекский ');
//     var textToTranslate = userMessage + additionalText;
    
//     // Отправляем ajax запрос на сервер, передавая данные формы
//     $.ajax({
//       url: 'default',
//       type: 'post',
//       data: formData,
//       success: function(response) {
//         // Если успешно получили ответ, вставляем его в блок с переводом
//         $('#translated_message').html(response);
//       }
//     });
    
//     // Очищаем поле ввода
//     $('#user_message').val('');
// });

// Обработчик нажатия клавиши "Enter" на поле ввода
$('#user_message').keypress(function(event) {
    // Если нажата клавиша "Enter"
    if (event.which === 13) {
        // Получаем значение выбранного языка перевода
        var lang = $('#lang').val();
        
        // Получаем значение поля ввода
        var userMessage = $('#user_message').val();
        
        // Добавляем значение из value в конец строки
        var additionalText = (lang == 'rus' ? ' переведи на русский ' : ' переведи на узбекский ');
        var textToTranslate = userMessage + additionalText;
        
        // Очищаем поле ввода и добавляем измененное значение с запросом на перевод
        $('#user_message').val(textToTranslate);
    }
        // Отправляем ajax запрос на сервер, передавая данные формы
        $.ajax({
            url: 'default',
            type: 'post',
            data: formData,
            success: function(response) {
              // Если успешно получили ответ, вставляем его в блок с переводом
              $('#translated_message').html(response);
            }
          });
        // Очищаем поле ввода
        $('#user_message').val('');
});