// const link = `http://${window.location.hostname}/Web-Blog-Peteboc/app/controller/client/`;
import { commentsPost } from "./component/comment/comment"
import { ownerPostAvatar, postContent, postFooter, postHead, postImage, postSetting } from "./component/post/post"

function callApi(url, option, callback) {
    fetch(url, {option})
        .then(response =>  response.json() )
        .then(data => { callback(data) })
        .catch(error => { console.log('Error: ', error) })
}

function callApiWithSelector(url, option, callback, selector) {
    fetch(url, {option})
        .then(response =>  response.json() )
        .then(data => { callback(data, selector) })
        .catch(error => { console.log('Error: ', error) })
}

const callAjax = (option, callback) => {
    $.ajax(option)
        .then((data) => callback(JSON.parse(data)));
}

const renderPost = (_data) => {
    var postArea = document.querySelector('#post__area');
    _data.forEach((value) => {
        postArea.innerHTML += `
                <div id="post__id-${value.id}" class="post__box border-radius-smooth ground-color-white box-shadow-6">
                    <div class="post__box-body">
                        <div class="post__heading">
                            ${ownerPostAvatar(value.avatar)}
                            ${postHead(value.realname, value.datetime, value.mode)}
                            ${postSetting(value.owner)}
                        </div>
                        ${postContent(value.content)}
                    </div>
                    ${postImage(value.image)}
                    ${postFooter()}
                    <div class="post__comment-area">

                    </div>
                </div>
                `;
        
        let url = `${linkApi}/comment.php?post_id=${value.id}`;
        let option = {
            method: 'GET'
        }
        callApiWithSelector(url, option, renderComments, `#post__id-${value.id} .post__comment-area`);
    });
}

const renderComments = (_data, selector) => {
    if (_data) {
        var html = _data.map((comment) => {
            return commentsPost(comment.avatar, comment.realname, comment.datetime, comment.message, comment.link, comment.owner);
        });
        document.querySelector(selector).innerHTML = html.join('');
    }
} 

const getAllPost = () => {
    const option = {
        method: 'GET'
    }
    const url = `${linkApi}/post.php`;
    callApi(url, option, renderPost);
}

getAllPost();