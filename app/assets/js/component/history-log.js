const renderHistoryLog = (action, datetime) => {
    return `
        <tr class="profile__history-box--row">
            <th style="width: 60%;">${action}</th>
            <th style="width: 40%;">${datetime}</th> 
        </tr>
    `;
}

export { renderHistoryLog }