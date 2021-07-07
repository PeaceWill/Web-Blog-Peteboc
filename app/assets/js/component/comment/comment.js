const commentsPost = (avatarURL, displayName, datetime, content, link, owner, commentID) => {
    return `
            <div class="post__user__comment">
                <a href="user.php?link=${link}">
                    <img class="post__avatar circle-avatar post__user__comment-avatar" src="./assets/img/avatar/${avatarURL}" alt="">
                </a>
                <div class="post__user__comment-body">
                    <div>
                        <a class="font-verdana--geneva post__user__comment-name" href="user.php?link=${link}">${displayName}</a>
                        <span class="post__user__comment-time">${datetime}</span>
                    </div>
                    <div class="post__user__comment-content">${content}</div>
                </div>
                ${commentSetting(owner, commentID)}
            </div>`;
}

const commentSetting = (owner, commentID) => {
    if (owner) {
        return `
                <span class="post__user__comment-setting">
                    <i class="fas fa-ellipsis-h"></i>
                    <ul class="post__user__comment-setting-list box-shadow-6 font-rajdhani">
                        <li class="post__user__comment-setting-select comment__edit" onclick="openEditCommentModal(${commentID})">Edit</li>
                        <li class="post__user__comment-setting-select commetn__remove" onclick="confirmBox(${commentID})">Remove</li>
                    </ul>
                </span>`;
    } else {
        return '';
    }
}

export { commentsPost };