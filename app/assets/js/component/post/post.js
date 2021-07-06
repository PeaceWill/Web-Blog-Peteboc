const ownerPostAvatar = (avataURL, userLink) => {
    return `
            <a class="" href="user.php?link=${userLink}">
                <img class="post__avatar circle-avatar" src="./assets/img/avatar/${avataURL}" alt="">
            </a>`;
}

const postHead = (displayName, datetime, mode) => {
    return `
            <div class="flex-col pad-left-12 flex-growth-2">
                <span class="font-verdana--geneva post__owner">${displayName}</span>
                <div style="display: flex;">
                    <span class="post__time">${datetime}</span>
                    <span class="post__mode">
                        ${postMode(mode)}
                    </span>
                </div>
            </div>`;
}

const postMode = (mode) => {
    if (mode == 1) {
        return `<i class="fas fa-users"></i>`;
    }
}

const postSetting = (owner, postID) => {
    if (owner) {
        return `
                <span class="post__setting">
                    <i class="fas fa-ellipsis-h"></i>
                    <ul class="post__setting-list box-shadow-6 font-rajdhani">
                        <li id="post__setting-edit" class="post__setting-select" onclick="openEditPostModal(${postID})">Edit</li>
                        <li id="post__setting-remove" class="post__setting-select" onclick="deletePost(${postID})">Remove</li>
                    </ul>
                </span>`;
    } 
    else {
        return ``;
    }
}

const postContent = (content) => {
    return `
            <div class="post__content">
                <p>${content}</p>
            </div>`;
}

const postImage = (imageURL) => {
    return `
    <div class="post__box-image">
        <img src="./assets/img/post/${imageURL}" alt="">
    </div>`;
}

const postFooter = (postID) => {
    return `
            <div class="post__footer">
                <span class="post__activity border-radius-smooth" id="comment__post-${postID}" onclick="openAddCommentModal(${postID})">
                    <i class="far fa-comment pad-right-10"></i>
                    Bình luận
                </span>
                
            </div>`;
}

export {  ownerPostAvatar, postHead, postSetting, postContent, postImage, postFooter } 