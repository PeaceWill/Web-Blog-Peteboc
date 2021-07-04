const linkApi = `http://${window.location.hostname}/Web-Blog-Peteboc/app/controller/client/mail.php`;
const email = document.querySelector('input[name=email]');
var sendButton = document.querySelector('#submit-email');
sendButton.onclick = (event) => {
    event.preventDefault();
    document.querySelector('.form__recover-message').innerText = 'Đang xử lý ...';
    $.ajax({
        url: `${linkApi}`,
        type: 'POST',
        cache: false,
        data: `email=${email.value}`
    }).then((data) => {
        data = JSON.parse(data);
        const spanMessage = document.querySelector('.form__recover-message');
        if (data.status == 0) {
            spanMessage.innerText = data.message;
            spanMessage.style.color = 'red';
        } else if (data.status == 1) {
            spanMessage.innerText = data.message;
            spanMessage.style.color = 'green';
        }
    });
}