var linkApi = `http://${window.location.hostname}/Web-Blog-Peteboc/app/controller/admin`;

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
        contentType: false,
        processData: false,
        success: ((data) => {
            callback(data);
        })
    });
}

// Send image
function callAjaxWithImage(option, callback) {
    $.ajax({
        url: option.url,
        type: option.type,
        data: option.data,
        contentType: false,
        processData: false,
        success: (data) => {
            callback(data);
        }
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
        var avatar = document.querySelector('#upload-avatar').files[0];
        var inputData = getFormData($('#form__user-create'));
        var fd = new FormData();
        fd.append('avatar', avatar);
        fd.append('data', JSON.stringify(inputData));
        fd.append('action', 'create');
        var option = { 
            'url': link,
            'type': 'POST', 
            'data': fd
        };
        callAjaxWithImage(option, renderCreateUser);
    }
}

function updateUser() {
    var button = document.querySelector('#submit__user-info');
    button.onclick = (event) => {
        event.preventDefault();
        var link = `${linkApi}/user.php`;
        var avatar = document.querySelector('#upload-avatar').files[0];
        var inputData = getFormData($('#form__user-info'));
        var fd = new FormData();
        fd.append('avatar', avatar);
        fd.append('data', JSON.stringify(inputData));
        fd.append('action', 'update');
        var option = {
            'url': link,
            'type': 'POST',
            'data': fd
        }
        callAjaxWithImage(option, alertFunc);
    }
}

function updateIntroduction() {
    var button = document.querySelector('#submit__intro');
    button.onclick = (event) => {
        event.preventDefault();
        var link = `${linkApi}/about.php`;
        var myContent = (tinyMCE.activeEditor.getContent()); 
        var fd = new FormData();
        fd.append('content', myContent);
        var option = {
            'url': link,
            'type': 'POST',
            'data': fd
        }
        callAjax(option, ((data) => {console.log(data)}));
    }
}

function getListUser() {
    var link = `${linkApi}/user.php`;
    callApi(link, 'GET', renderListUser);
}

function getUserInfo() {
    var url = window.location.href.split('?');
    var link = `${linkApi}/user.php?${url[1]}`;
    $(document).ready(() => {
        callApi(link, 'GET', renderUserInfo);
    });
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
    data = JSON.parse(data);
    alert(data.message);
    var input = document.querySelectorAll('input[class=form__input]');
    input.forEach((item) => {
        item.value = '';
    });
    document.querySelector('textarea').value = '';
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

function renderUserInfo(data) {
    document.querySelector('input[name=username]').value = data.username;
    document.querySelector('input[name=email]').value = data.email;
    document.querySelector('input[name=realname]').value = data.realname;
    document.querySelector('input[name=phone]').value = data.phone;
    document.querySelector('textarea[name=description]').value = data.description;
    document.querySelector('input[name=link]').value = data.link;
    document.querySelector('input[name=address]').value = data.address;
    var genderSelect = document.querySelectorAll('input[name=gender]');
    genderSelect.forEach((item) => {
        if (item.value == data.gender) {
            item.setAttribute('checked', true);
        }
    })
    document.querySelector('select').options.selectedIndex = data.level;
    document.querySelector('.circle-avatar.form__info-avatar').src = `../../assets/img/avatar/${data.avatar}`;
}

function getFormData(selector){
    var unindexed_array = selector.serializeArray();
    var indexed_array = {};

    $.map(unindexed_array, function(n, i){
        indexed_array[n['name']] = n['value'];
    });

    return indexed_array;
}

function alertFunc(data) {
    data = JSON.parse(data);
    alert(data.message);
    window.location.reload();
}