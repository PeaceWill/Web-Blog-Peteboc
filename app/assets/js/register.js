const button = document.querySelector('#register__button');
const link = `http://${window.location.hostname}/Web-Blog-Peteboc/app/controller/client/user.php`;

button.onclick = (e) => {
    e.preventDefault();
    $.ajax({
        url: link,
        type: 'POST',
        data: $('.form__register').serialize(),
        success: (_data) => { render(JSON.parse(_data)) }
    })
}

const render = (_data) => {
    if (_data.status == 0) {
        document.querySelector('#response__msg').innerText = _data.message;
    }
    else if (_data.status == 1) {
        $alert(_data.message, '#4484ba');
    }
}