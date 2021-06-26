var linkApi = 'http://localhost/Web-Blog-Peteboc/app/controller/admin';

// Fetch api
function callApi(url, method, callback) {
    fetch(url, {
        method: method,
    })
    .then(response => {
        return response.json();
    })
    .then(data => {
        callback(data);
    })
    .catch((error) => {
        console.log('Error: ',error);
    });
}

// Call ajax
function callAjax(option, callback) {
    $.ajax({
        url: option.url,
        type: option.type,
        data: option.data,
        success: ((data) => {
            callback(JSON.parse(data));
        })
    });
}

// Send image
function sendImage(option, callback) {
    var fd = new FormData();
    var avatar = $('#upload-avatar')[0].files[0];
    fd.append('avatar', avatar);
    var username = document.querySelector('input[name=username]').value;
    $.ajax({
        url: `${option.url}/user.php?username=${username}`,
        type: option.type,
        data: fd,
        contentType: false,
        processData: false,
        success: ((data) => {
            
        })
    });
}

function createDashboard() {
    var link = `${linkApi}/user.php?action=count`;
    callApi(link, 'GET', renderStrectCard);
}

function createUser() {
    var button = document.querySelector('#submit__user-create');
    button.onclick = (event) => {
        event.preventDefault();
        var link = `${linkApi}/user.php`;
        var option = { 
            'url': link,
            'type': 'POST', 
            'data': $('#form__user-create').serialize()
        };
        callAjax(option, renderCreateUser);
        sendImage(option, '');
    }
}

function getListUser() {
    var link = `${linkApi}/user.php`;
    callApi(link, 'GET', renderListUser);
}

function renderStrectCard(data) {
    var number_user = document.querySelector('#number__user');
    var number_online = document.querySelector('#number__online');
    var number_week = document.querySelector('#number__create-week');
    var number_post = document.querySelector('#number__post');
    var number_log = document.querySelector('#number__log');

    if (number_user) {
        number_user.innerText = data.all.number;
    }
    if (number_online) {
        number_online.innerText = data.online.number;
    }
    if (number_week) {
        number_week.innerText = data.create_week.number;
    }
    console.log(number_post);
    console.log(number_log);
}

function renderCreateUser(data) {
    alert(data.message);
} 

function renderListUser(data) {
    var list = document.querySelector('#list__user-show');
    var html = data.map((user) => {
        return `<a href="user-profile.php?username=${user.username}">
                    <ul class="row no-gutters table__log__item hover-08">
                        <li class="l-3 m-3 c-3 tabl__log__cell">
                            <span class="log__thumb" href="">
                                <img class="circle-avatar log__avatar" src="../../assets/img/avatar/${user.avatar}" alt="">
                                <span class="log__username">${user.username}</span>
                            </span>
                        </li>
                        <li class="l-3 m-3 c-3 tabl__log__cell">
                            ${user.realname} 
                        </li>
                        <li class="l-3 m-3 c-3 tabl__log__cell">
                            ${user.email}
                        </li>
                        <li class="l-3 m-3 c-3 tabl__log__cell">
                            ${user.date_create}
                        </li>
                    </ul>
                </a>`;
    });
    list.innerHTML += html.join('');
}
