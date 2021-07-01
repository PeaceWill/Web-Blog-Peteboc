var linkApi = `http://${window.location.hostname}/Web-Blog-Peteboc/app/controller/client`;

var fetchApi = (url, option, callback) => {
    fetch(url, {option})
        .then(response => response.json())
        .then((data) => { callback(data) })
        .catch(error => { console.log('Error: ',error) })
}

var callAjax = (option, callback) => {
    $.ajax(option)
    .then(data => { callback(data) }) 
}

var renderProfile = (_data) => {
    var avatar = document.querySelector('#profile__avatar').src = `assets/img/avatar/${_data.avatar}`;
    var realname = document.querySelector('#profile__realname').value = _data.realname;
    var email = document.querySelector('#profile__email').value = _data.email;
    var phone = document.querySelector('#profile__phone').value = _data.phone;
    var address = document.querySelector('#profile__address').value = _data.address;
    var link = document.querySelector('#profile__link').value = _data.link;
    var desc = document.querySelector('#profile__description').innerText = _data.description;
    var genderOptions = document.querySelectorAll('input[name=gender]');
    genderOptions.forEach((element) => {
        if (element.value == _data.gender) {
            element.setAttribute('checked', true);
        }
    });
}

var alertFunc = (_data) => {
    data = JSON.parse(_data);
    alert(data.message);
}

var alertBox = (_data) => {
    data = JSON.parse(_data);
    if (data.status == 1) {
        $alert(data.message, '#4484ba');
    } else {
        $alert(data.message, '#d54f3e');
    }
}

function fetchData() {
    var url = `${linkApi}/user.php`;
    option = {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
        },
    }
    fetchApi(url, option, renderProfile);
}

function updateUser() {
    var buttonUpdateInfo = document.querySelector('#update__user-info');
    buttonUpdateInfo.onclick = (event) => {
        event.preventDefault();
        let avatar = document.querySelector('#upload-avatar').files[0];
        let formData = getFormData($('#form__update-info'));
        let fd = new FormData();
        fd.append('avatar', avatar);
        fd.append('data', JSON.stringify(formData));
        fd.append('action', 'update')
        let option = {
            url: `${linkApi}/user.php`,
            type: 'POST',
            data: fd,
            contentType: false,
            processData: false,
        }
        callAjax(option, alertBox);
    }

    var buttonUpdatePass = document.querySelector('#update__user-password');
    buttonUpdatePass.onclick = (event) => {
        event.preventDefault();
        let data = $('#form__update-password').serialize();
        console.log(data);
        let option = {
            url: `${linkApi}/user.php`,
            type: 'POST',
            data: data,
        }
        callAjax(option, alertBox)
    }
}

const uploadAvatar = document.querySelector('#upload-avatar');
const avatarPreview = document.querySelector('#profile__avatar'); 
uploadAvatar.addEventListener('change', () => { 
    const file = uploadAvatar.files[0];
    if (file) {
        const fileReader = new FileReader();
        fileReader.readAsDataURL(file);
        fileReader.addEventListener('load', () => {
            avatarPreview.src = fileReader.result;
        });
    }
});

function getFormData(selector){
    var unindexed_array = selector.serializeArray();
    var indexed_array = {};

    $.map(unindexed_array, function(n, i){
        indexed_array[n['name']] = n['value'];
    });

    return indexed_array;
}