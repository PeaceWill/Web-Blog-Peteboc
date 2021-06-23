function catchEventLog() {
    var modal = document.querySelector('.modal');
    var modal_overlay = document.querySelector('.modal__overlay');
    var modal_login = document.querySelector('#form__modal-log');
    
    document.querySelector('#open__login__modal').onclick = () => {
        modal.style.display = 'block';
    }

    document.querySelector('#open__signup__modal').onclick = () => {
        window.location.href = "https://www.google.com";
    }

    window.onclick = (event) => {
        if (event.target == modal_overlay) {
            modal.style.display = 'none';
        }
    }
}

function openEditPostModal() {
    var openButton = document.querySelector('#post__setting-edit');
    openButton.onclick = () => {
        document.querySelector('.edit__post-frame').style.display = 'block';
    }
}

function closeEditPostModal() {
    var closeButton = document.querySelector('#close__edit');
    closeButton.onclick = () => {
        document.querySelector('.edit__post-frame').style.display = 'none';
    }
}