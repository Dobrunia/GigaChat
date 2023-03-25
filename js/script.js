"use strict"
let chat_form = document.getElementById("chat_form"),
    message_text = document.getElementById("message_text"),
    companion_name = document.getElementById("companion_name"),
    search = document.getElementById('search'),
    search_container = document.querySelector('.search_container'),
    search_btn = document.querySelector('.search_btn');

function update_messages() {//Обновляет сообщения в чате, нужно переделать, чтобы обновлялось если есть изменения БД, а не через setInterval
    
    if (companion_name.textContent.trim() !== '') {
        let xhr = new XMLHttpRequest();
        xhr.open('GET', '../ajax.php?companion_name=' + companion_name.textContent.trim() + '&update=true', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send();
        xhr.onreadystatechange = function() {

        if (xhr.readyState == 4) {//Если обмен данными завершен
            document.getElementById('messages').innerHTML = xhr.responseText;
        }

        }
    }

}
setInterval(update_messages, 5000);

function update_companions() {//Обновляет список чатов слева(пользователей с кем есть хоть 1 сообщение), тоже переделать
    let xhr = new XMLHttpRequest();
    xhr.open('GET', '../ajax.php?companions=true', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send();
    xhr.onreadystatechange = function() {

        if (xhr.readyState == 4) {
            document.getElementById("user").innerHTML = xhr.responseText;
            let selects = document.querySelectorAll('.companion');
            selects.forEach(function(select) {
                select.addEventListener('click', function() {
                    companion_name.innerHTML = this.textContent.trim();
                });
            });
        }

    }
}
setInterval(update_companions, 10000);

function save_message() {//Сохраняет сообщения в БД

    if (message_text.value.trim().length > 0) {
        let message = message_text.value.trim();
        let xhr = new XMLHttpRequest();
        xhr.open('POST', '../ajax.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send('message=' + message + '&companion_name=' + companion_name.textContent.trim() + '&save=' + true);
        xhr.onreadystatechange = function() {
          if (xhr.readyState == 4) {
              message_text.value = "";
          }
      }
    } else {
        message_text.value = "";
    }

}

chat_form.addEventListener('submit', function (event) {
    event.preventDefault();
    save_message();
});

function drawFriends() {//поиск пользователей
    let searchTerm = search.value.trim();
    let xhr = new XMLHttpRequest();
    xhr.open('GET', '../ajax.php?searchTerm=' + searchTerm, true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send();
    xhr.onreadystatechange = function() {

        if (xhr.readyState == 4) {
            search_container.innerHTML = xhr.responseText;
            search_container.style.display = 'block';
            let friends = document.querySelectorAll('.friend');

            friends.forEach(function(select) {
                select.addEventListener('click', function() {
                    companion_name.innerHTML = this.textContent.trim();
                });
            });
            
        }

    }
}
search.addEventListener('change', () => {drawFriends()});
search_btn.addEventListener('click', () => {drawFriends()});

document.addEventListener( 'click', (e) => {
	const withinBoundaries = e.composedPath().includes(search_container);

	if (!withinBoundaries && !e.composedPath().includes(search)) {
		search_container.style.display = 'none'; // скрываем элемент т к клик был за его пределами
	}
    
});

document.addEventListener('keydown', function(e) {

	if(e.keyCode == 27) { // код клавиши Escape
		search_container.style.display = 'none';
	}

});

update_companions(); //первая отрисовка