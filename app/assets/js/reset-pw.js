const linkApi = `http://${window.location.hostname}/Web-Blog-Peteboc/app/controller/client/user.php`;
const submitButton = document.querySelector('button');
submitButton.onclick = (event) => {
    event.preventDefault();
    const pw = document.querySelector('input[name=password]').value;
    const re_pw = document.querySelector('input[name=re-password]').value;
    if (pw != re_pw) {
        document.querySelector('.form__recover-message').innerText = 'Mật khẩu nhập không khớp';
    } else {
        $.ajax({
            url: linkApi,
            type: 'POST',
            data: $('form').serialize()
        })
        .then((data) => {
            data = JSON.parse(data);
            alert(data.message);
            if (data.status == 1) {
                window.location.reload();
            }
        });
    }
}