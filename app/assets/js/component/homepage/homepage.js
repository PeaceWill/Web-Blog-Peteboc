const userPageInfo = (avatarURL, displayName, postNumber, description) => {
    return `
            <div class="user__info__avatar-box">
                <img class="circle-avatar user__info__avatar" src="./assets/img/avatar/${avatarURL}" alt="">
            </div>
            <div class="user__info-box">
                <div class="user__info-realname">
                    ${displayName}
                </div>
                <div class="user__info-post--public">
                    ${postNumber ? postNumber : 0} Bài viết
                </div>
                <div class="user__info-desc">
                    ${description}
                </div>
            </div>`;
}

export { userPageInfo }