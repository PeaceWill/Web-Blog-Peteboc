function catchEventLog() {
    var modal = document.querySelector('.modal');
    var modal_overlay = document.querySelector('.modal__overlay');
    var modal_login = document.querySelector('#form__modal-log');
    
    document.querySelector('#open__login__modal').onclick = () => {
        modal.style.display = 'block';
    }

    window.onclick = (event) => {
        if (event.target == modal_overlay) {
            modal.style.display = 'none';
        }
    }
}

function openEditPostModal() {
    document.querySelector('.edit__post-frame').style.display = 'block';
    var modeSelected = document.querySelector('#mode-selected');
    var modePrivate = document.querySelector('#mode-private');
    var modepublic = document.querySelector('#mode-public');
    var modeSelect = document.querySelectorAll('.mode-select');
    modeSelect.forEach((mode) => {
        mode.onclick = (event) => { 
            if (event.target == modePrivate) {
                modeSelected.classList.replace('fa-users', 'fa-unlock-alt');
            } else if (event.target == modepublic) {
                modeSelected.classList.replace('fa-unlock-alt', 'fa-users');
            }
         }
    });
}

function closeEditPostModal() {
    var closeButton = document.querySelector('#close__edit-post');
    closeButton.onclick = () => {
        document.querySelector('.edit__post-frame').style.display = 'none';
    }
}

function openEditCommentModal() {
    var editModal = document.querySelector('.edit__comment-frame');
    editModal.style.display = 'block';
}

function closeEditCommentModal() {
    var closeButton = document.querySelector('#close__edit-comment');
    closeButton.onclick = () => {
        document.querySelector('.edit__comment-frame').style.display = 'none';
    }
}

function openAddCommentModal() {
    var addComment = document.querySelector('.add__comment-frame');
    addComment.style.display = 'block';
}

function closeAddCommentModal() {
    var closeButton = document.querySelector('#close__add-comment');
    closeButton.onclick = () => {
        document.querySelector('.add__comment-frame').style.display= 'none';
    }
}

function selectMode() {
    var modeSelected = document.querySelector('#mode-selected');
    var modePrivate = document.querySelector('#mode-private');
    var modePublic = document.querySelector('#mode-public');
    var selections = document.querySelectorAll('.mode-select');
    selections.forEach((select) => {
        select.onclick = (mode) => {
            if (mode.target == modePrivate) {
                modeSelected.classList.replace('fa-users' ,'fa-unlock-alt')
            } else if (mode.target == modePublic) {
                modeSelected.classList.replace('fa-unlock-alt', 'fa-users');
            }
        }
    })
}

var linkApi = `http://${window.location.hostname}/Web-Blog-Peteboc/app/controller/client`;

var sendAjax = (option, callback) => {
    $.ajax({
        url: option.url,
        type: option.type,
        data: option.data,
        success: (_data) => {
            callback(_data);
        }
    });
}

var renderModal = (_data) => {
    data = JSON.parse(_data);
    if (data.status == 0) {
        document.querySelector('.modal__error__message').innerText = data.message;
    } else {
        window.location.reload();
    }
}


function login() {
    var logButton = document.querySelector('#log__button');
    logButton.onclick = (event) => {
        event.preventDefault();
        option = {
            url: `${linkApi}/user.php`,
            type: 'GET',
            data: $('#form__modal-log').serialize()
        }
        sendAjax(option, renderModal);
    }
}
