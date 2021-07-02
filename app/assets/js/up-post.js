import { previewImage } from "./component/provider/previewImage"

const uploadImage = () => {
    previewImage('#upload__image-post', '#post__image');
}

const uploadPost = () => {
    const buttonSubmit = document.querySelector('#upload__post');
    buttonSubmit.onclick = () => {
        let image = document.querySelector('#upload__image-post').files[0];
        let data = { 'content': document.querySelector('textarea[name=content]').value }
        let fd = new FormData();
        fd.append('image', image);
        fd.append('data', JSON.stringify(data));
        $.ajax({
            url: `${linkApi}/post.php`,
            type: 'POST',
            data: fd,
            contentType: false,
            processData: false
        }).then((data) => { console.log(data) });
    }
}

uploadImage();
uploadPost();