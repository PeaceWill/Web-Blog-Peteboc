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
            console.log(data);
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
    }
}

function renderStrectCard(data) {
    var number_user = document.querySelector('#number__user');
    var number_online = document.querySelector('#number__online');
    var number_post = document.querySelector('#number__post');
    var number_log = document.querySelector('#number__log');

    number_user.innerText = data.all.number;
    number_online.innerText = data.online.number;
    console.log(number_post);
    console.log(number_log);
}

function renderCreateUser($data) {
    console.log(data);
} 

