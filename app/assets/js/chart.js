function LineChart() {
    var ctx = $('#line__chart-user');
    var lineChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep',
                        'Oct', 'Nov', 'Dec'],
            datasets: [
                {
                    label: 'User 2021',
                    data: [0,5,10,13,23,24,24,25,26,26,30,32]
                }
            ]
        }
    });
}