import { renderHistoryLog } from "./component/history-log";

const fetchHistory = async (url) => {
    let data = await fetch(url);
    return data.json();
}

const historyApi = `${linkApi}/history.php`;
fetchHistory(historyApi)
    .then((actions) => {
        let html = actions.map((action) => {
            return `
                ${renderHistoryLog(action.action, action.datetime)}
            `;
        });
        document.querySelector('table').innerHTML += html.join('');
    })