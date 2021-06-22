function LineChart() {
    var ctx = $('#line__chart-user');
    var lineChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Mon', 'Tue', 'Wes', 'Thur', 'Fri', 'Sat', 'Sun'],
            datasets: [
                {
                    label: 'Post in week',
                    data: [0,5,20,13,23,14,4],
                    backgroundColor: '#fff',
                    borderColor: '#4885a2'
                },
                {
                    label: 'Log in week',
                    data: [0,1,4,11,33,4,24],
                    backgroundColor: '#fff',
                    borderColor: '#b29d50'
                }
            ],
        },
        options: {
            scales: {
                xAxes: [{
                    gridLines: {
                        display:false
                    }
                }],
                yAxes: [{
                    gridLines: {
                        display:false
                    }   
                }]
            }
        }
    });
}