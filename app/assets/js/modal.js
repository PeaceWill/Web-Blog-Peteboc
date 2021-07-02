var linkApi = `http://${window.location.hostname}/Web-Blog-Peteboc/app/controller/client`;

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

function openEditPostModal(postID) {
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
    const option = {
        url: `${linkApi}/post.php`,
        type: 'GET',
        data: `id=${postID}`
    }
    sendAjax(option, renderEditModal);
    const uploadImage = document.querySelector('#edit-post-image');
    const imagePreview = document.querySelector('#form__edit-image'); 
    uploadImage.addEventListener('change', () => { 
        const file = uploadImage.files[0];
        if (file) {
            const fileReader = new FileReader();
            fileReader.readAsDataURL(file);
            fileReader.addEventListener('load', () => {
                imagePreview.src = fileReader.result;
            });
        }
    });

    const buttonSubmit = document.querySelector('.edit__button');
    buttonSubmit.onclick = () => {
        const image = document.querySelector('#edit-post-image').files[0];
        const content = document.querySelector('#form__edit-content').value;
        let fd = new FormData();
        fd.append('image', image);
        fd.append('content', content);
        fd.append('id', postID);
        fd.append('action', 'update');
        const option = {
            url: `${linkApi}/post.php`,
            type: 'POST',
            data: fd,
            contentType: false,
            processData: false
        }
        sendAjax(option, reloadPage);
    }
}

function closeEditPostModal() {
    var closeButton = document.querySelector('#close__edit-post');
    closeButton.onclick = () => {
        document.querySelector('.edit__post-frame').style.display = 'none';
    }
}

function openEditCommentModal(commentID) {
    const editModal = document.querySelector('.edit__comment-frame');
    editModal.style.display = 'block';
    const buttonSubmit = editModal.querySelector('#edit__comment');
    buttonSubmit.onclick = () => {
        const commentMessage = editModal.querySelector('#edit__comment-input').value;
        const option = {
            url: `${linkApi}/comment.php`,
            type: 'PUT',
            data: `action=update&id=${commentID}&message=${commentMessage}`,
        }
        sendAjax(option, reloadPage);
    }
}

function closeEditCommentModal() {
    var closeButton = document.querySelector('#close__edit-comment');
    closeButton.onclick = () => {
        document.querySelector('.edit__comment-frame').style.display = 'none';
    }
}

function openAddCommentModal(postID) {
    const addComment = document.querySelector('.add__comment-frame');
    addComment.style.display = 'block';
    const buttonSubmit = addComment.querySelector('#add__comment');
    buttonSubmit.onclick = () => {
        const commentMessage = addComment.querySelector('#add__comment-input').value;
        const option = {
            url: `${linkApi}/comment.php`,
            type: 'POST',
            data: `post_id=${postID}&message=${commentMessage}`
        }
        sendAjax(option, reloadPage);
        
    }
}

function closeAddCommentModal() {
    var closeButton = document.querySelector('#close__add-comment');
    closeButton.onclick = () => {
        document.querySelector('.add__comment-frame').style.display= 'none';
    }
}

function deleteComment(commentID) {
    const option = {
        url: `${linkApi}/comment.php`,
        type: 'DELETE',
        data: `id=${commentID}`
    }
    sendAjax(option, reloadPage);
}

function deletePost(postID) {
    $confirm('Xóa bài viết?', '#d54f3e')
        .then(() => {
            const option = {
                url: `${linkApi}/post.php`,
                type: 'DELETE',
                data: `id=${postID}`
            }
            sendAjax(option, reloadPage );
        })
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


const sendAjax = (option, callback) => {
    $.ajax({
        url: option.url,
        type: option.type,
        data: option.data,
        contentType: option.contentType,
        processData: option.processData,
        success: (_data) => {
            callback(_data);
        }
    });
}

const renderModal = (_data) => {
    data = JSON.parse(_data);
    if (data.status == 0) {
        document.querySelector('.modal__error__message').innerText = data.message;
    } else {
        window.location.reload();
    }
}

const renderEditModal = (_data) => {
    data = JSON.parse(_data);
    const avatar = document.querySelector('#form__edit-avatar').src = `./assets/img/avatar/${data.avatar}`;
    const displayName = document.querySelector('#form__edit-realname').innerText = data.realname;
    const content = document.querySelector('#form__edit-content').innerText = `${data.content}`;
    const image = document.querySelector('#form__edit-image').src = `./assets/img/post/${data.image}`;

}

function reloadPage(_data) {
    data = JSON.parse(_data);
    if (data.status == 0) {
        $alert(data.message, '#d54f3e');
    }
    else if (data.status == 1) {
        window.location.reload();
    }
}

function confirmBox(commentID) {
    $confirm('Xóa comment?', '#d54f3e')
        .then(() => {
            deleteComment(commentID);
        })
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
