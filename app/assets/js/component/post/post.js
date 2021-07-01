const ownerPostAvatar = (avataURL) => {
    return `
            <figure class="">
                <img class="post__avatar circle-avatar" src="./assets/img/avatar/${avataURL}" alt="">
            </figure>`;
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
    if (mode == 0) {
        return `<i class="fas fa-unlock-alt"></i>`;
    } 
    else if (mode == 1) {
        return `<i class="fas fa-users"></i>`;
    }
}

const postSetting = (owner) => {
    if (owner) {
        return `
                <span class="post__setting" onclick="openEditPostModal()">
                    <i class="fas fa-ellipsis-h"></i>
                    <ul class="post__setting-list box-shadow-6 font-rajdhani">
                        <li id="post__setting-edit" class="post__setting-select">Edit</li>
                        <li id="post__setting-report" class="post__setting-select">Report</li>
                        <li id="post__setting-remove" class="post__setting-select">Remove</li>
                    </ul>
                </span>`;
    } 
    else {
        return `
                <span class="post__setting">
                </span>`;
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

const postFooter = () => {
    return `
            <div class="post__footer">
                <span class="post__activity border-radius-smooth" id="post__comment-activity" onclick="openAddCommentModal()">
                    <i class="far fa-comment"></i>
                    Bình luận
                </span>
                <span class="post__activity border-radius-smooth" id="post__share-activity">
                    <i class="fas fa-share-square"></i>
                    Chia sẻ
                </span>
            </div>`;
}

export default 'heeloo';
export {  ownerPostAvatar, postHead, postSetting, postContent, postImage, postFooter } 