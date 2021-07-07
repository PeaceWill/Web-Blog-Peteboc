import { renderSearchUser } from "./component/search-user.js";

const reanderArea = document.querySelector('#search__area');

const fetchSearchData = async (url) => {
    let data = await fetch(url);
    return data.json();
}

const paramString = window.location.href.split('?')[1];
const searchApi = `${linkApi}/user.php?${paramString}`;

fetchSearchData(searchApi)
    .then((users) => {
        let html = users.map((user) => {
            return renderSearchUser(user.link, user.avatar, user.realname);
        });
        reanderArea.innerHTML += html.join('');
    });

