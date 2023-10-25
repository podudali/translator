// Получаем ссылки на элементы формы
let langSelect = $('#lang');
let inputField = $('#user_message');

// Обработчик выбора языка перевода
langSelect.change(function() {
    // Устанавливаем фокус на поле ввода
    inputField.focus();
});
// Обработчик нажатия клавиши "Enter" на поле ввода
$('#user_message').keypress(function(event) {
    // Если нажата клавиша "Enter"
    if (event.which === 13) {
        // Получаем значение выбранного языка перевода
        var lang = $('#lang').val();
        
        // Получаем значение поля ввода
        var userMessage = $('#user_message').val();
        
        // Добавляем значение из value в конец строки
        var additionalText = '';
        if(lang == 'rus'){
        additionalText = ' переведи на русский ';
        }else if (lang == 'uzb'){
        additionalText = ' переведи на узбекский ';
        }else if (lang == 'eng'){
        additionalText = ' переведи на английский '; 
        }else if (lang == 'cz'){
        additionalText = ' переведи на чешский '; 
        }else if (lang == 'esp'){
        additionalText = ' переведи на испанский '; 
        }else if (lang == 'it'){
        additionalText = ' переведи на итальянский '; 
        }else if (lang == 'fra'){
        additionalText = ' переведи на французский '; 
        }else if (lang == 'de'){
        additionalText = ' переведи на немецкий '; 
        }else if (lang == 'bra'){
        additionalText = ' переведи на португальский '; 
        }else if (lang == 'chi'){
        additionalText = ' переведи на китайский ';
        }else if (lang == 'jpn'){
        additionalText = ' переведи на японский ';
        }
        var textToTranslate = userMessage + additionalText;  

        // Создаем объект FormData из данных формы
        let formData = new FormData();
        formData.append('user_message', textToTranslate);
        formData.append('lang', lang);
        
        // Очищаем поле ввода и добавляем измененное значение с запросом на перевод
        $('#user_message').val(textToTranslate);
    }
        // Отправляем ajax запрос на сервер, передавая данные формы
        $.ajax({
          url: 'default',
          type: 'post',
          data: formData,
          processData: false,
          contentType: false,
          success: function(response) {
            // Если успешно получили ответ, вставляем его в блок с переводом
            $('#translated_message').html(response);           
          }
      });

      // Очищаем поле ввода
      $('#user_message').val('');
      });

// $('#submit').click(function(event) {
//   event.preventDefault(); // блокируем стандартное поведение элемента "button"
  
//   // Получаем значение выбранного языка перевода
//   let lang = $('#lang').val();
  
//   // Получаем значение поля ввода
//   let userMessage = $('#user_message').val();
  
//   // Добавляем значение из value в конец строки
//   let additionalText = '';
//   if(lang == 'rus'){
//       additionalText = ' переведи на русский ';
//   } else if (lang == 'uzb'){
//       additionalText = ' переведи на узбекский ';
//   } else if (lang == 'eng'){
//       additionalText = ' переведи на английский '; 
//   } else if (lang == 'cz'){
//       additionalText = ' переведи на чешский '; 
//   } else if (lang == 'esp'){
//       additionalText = ' переведи на испанский '; 
//   } else if (lang == 'it'){
//       additionalText = ' переведи на итальянский '; 
//   } else if (lang == 'fra'){
//       additionalText = ' переведи на французский '; 
//   } else if (lang == 'de'){
//       additionalText = ' переведи на немецкий '; 
//   } else if (lang == 'bra'){
//       additionalText = ' переведи на португальский '; 
//   } else if (lang == 'chi'){
//       additionalText = ' переведи на китайский ';
//   } else if (lang == 'jpn'){
//       additionalText = ' переведи на японский ';
//   }
//   let textToTranslate = userMessage + additionalText;  
  
//    // Создаем объект FormData из данных формы
//    let formData = new FormData();
//    formData.append('user_message', textToTranslate);
//    formData.append('lang', lang);

//   // Отправляем ajax запрос на сервер, передавая данные формы
//   $.ajax({
//     url: 'default',
//     type: 'post',
//     data: formData,
//     processData: false,
//     contentType: false,
//     success: function(response) {
//       // Если успешно получили ответ, вставляем его в блок с переводом
//       $('#translated_message').html(response);           
//     }
// });

// // Очищаем поле ввода
// $('#user_message').val('');
// });