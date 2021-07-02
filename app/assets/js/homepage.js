import { userPageInfo } from "./component/homepage/homepage";
import { ownerPostAvatar, postHead, postSetting, postContent, postImage, postFooter } from "./component/post/post";
import { commentsPost } from "./component/comment/comment";

const callApi = (url, option, callback) => {
    fetch(url, {option})
        .then(data => data.json())
        .then(response => { callback(response) })
        .catch(error => { console.log('Error: ', error);})
}

function callApiWithSelector(url, option, callback, selector) {
    fetch(url, {option})
        .then(response =>  response.json() )
        .then(data => { callback(data, selector) })
        .catch(error => { console.log('Error: ', error) })
}

const renderUserPage = (_data) => {
    document.querySelector('.user__info__wrap').innerHTML = userPageInfo(_data.avatar, _data.realname, _data.post_number, _data.description);
}

const renderUserPosts = (data) => {
    var postArea = document.querySelector('#post__area');
    data.forEach((post) => {
        postArea.innerHTML += `
                            <div id="post__id-${post.id}" class="post__box border-radius-smooth ground-color-white box-shadow-6">
                                <div class="post__box-body">
                                    <div class="post__heading">
                                        ${ownerPostAvatar(post.avatar, post.link)}
                                        ${postHead(post.realname, post.datetime, post.mode)}
                                        ${postSetting(post.owner, post.id)}
                                    </div>
                                    ${postContent(post.content)}
                                </div>
                                ${postImage(post.image)}
                                ${postFooter(post.id)}
                                <div class="post__comment-area">

                                </div>
                            </div>`;
        let url = `${linkApi}/comment.php?post_id=${post.id}`;
        let option = {
            method: 'GET'
        }
        callApiWithSelector(url, option, renderComments, `#post__id-${post.id} .post__comment-area`);
    });
}

const renderComments = (_data, selector) => {
    if (_data) {
        var html = _data.map((comment) => {
            return commentsPost(comment.avatar, comment.realname, comment.datetime, comment.message, comment.link, comment.owner, comment.id);
        });
        document.querySelector(selector).innerHTML = html.join('');
    }
} 

const getUserPageInfo = () => {
    const queryString = window.location.href.split('?')[1];
    let url = `${linkApi}/user.php?${queryString}`;
    let option = { };
    callApi(url, option, renderUserPage);
}

const getUserPosts = () => {
    const queryString = window.location.href.split('?')[1];
    let url = `${linkApi}/post.php?${queryString}`;
    let option = { };
    callApi(url, option, renderUserPosts);
}

getUserPageInfo();
getUserPosts();