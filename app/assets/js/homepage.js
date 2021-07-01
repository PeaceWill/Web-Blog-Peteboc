import { userPageInfo } from "./component/homepage/homepage";
import { ownerPostAvatar, postHead, postSetting, postContent, postImage, postFooter } from "./component/post/post";

const callApi = (url, option, callback) => {
    fetch(url, {option})
        .then(data => data.json())
        .then(response => { callback(response) })
        .catch(error => { console.log('Error: ', error);})
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
                                        ${ownerPostAvatar(post.avatar)}
                                        ${postHead(post.realname, post.datetime, post.mode)}
                                        ${postSetting(post.owner)}
                                    </div>
                                    ${postContent(post.content)}
                                </div>
                                ${postImage(post.image)}
                                ${postFooter()}
                                <div class="post__comment-area">

                                </div>
                            </div>`;
    });
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