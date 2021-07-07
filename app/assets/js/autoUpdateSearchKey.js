import { getSearchUrl } from "./component/provider/getSearchInput.js";

const searchBox = document.querySelector('.search__input');
const searchURL = document.querySelector('#search__url');
searchBox.onkeyup = () => {
    searchURL.href = getSearchUrl(searchBox.value);
}