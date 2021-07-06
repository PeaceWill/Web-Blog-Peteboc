var link = `https://${window.location.hostname}/Web-Blog-Peteboc/app/controller/client/about.php`;
let content = document.querySelector('.article__content');

fetch(link, { method: 'GET' })
    .then(response => response.json())
    .then((_data) => { renderHTML(_data) })
    .catch((error) => { console.log('Error: ', error) })

const renderHTML = (_data) => {
    content.innerHTML = _data;
}