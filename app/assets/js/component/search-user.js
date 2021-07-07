const renderSearchUser = (userLink, avatarURL, displayName) => {
    return `
        <div class="post__box post__mini border-radius-smooth ground-color-white box-shadow-6">
            <a class="post__mini__heading" href="user.php?link=${userLink}">
                <img class="circle-avatar post__avatar" src="./assets/img/avatar/${avatarURL}" alt="">
                <div class="post__mini__owner">${displayName}</div>
            </a>
        </div>
    `;
}

export { renderSearchUser }