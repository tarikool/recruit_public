<script>

    "use script"

    var statistics_chart = document.getElementById("statisticsChart");

    let chartLabelsArray = {!! $stackChartLabels !!};
    let jobsChartData = {!! $jobsChartData !!};
    let clientChartsData = {!! $clientChartsData !!};
    let candidateChartsData = {!! $candidateChartsData !!};
    let contactChartsData = {!! $contactChartsData !!};

    var statisticsChart = new Chart(statistics_chart, {
        type: 'bar',
        data: {
            labels: chartLabelsArray,
            datasets: [
                {
                    label: '{{__("Job")}}',
                    backgroundColor: "#3e95cd",
                    data: [
                        // jobsChartData
                        jobsChartData.january, jobsChartData.february,
                        jobsChartData.march, jobsChartData.april,
                        jobsChartData.may, jobsChartData.june,
                        jobsChartData.july, jobsChartData.august,
                        jobsChartData.september, jobsChartData.october,
                        jobsChartData.november, jobsChartData.december
                    ]
                }, {
                    label: '{{__("Candidate")}}',
                    backgroundColor: "#b84c87",
                    data: [
                        candidateChartsData.january, candidateChartsData.february,
                        candidateChartsData.march, candidateChartsData.april,
                        candidateChartsData.may, candidateChartsData.june,
                        candidateChartsData.july, candidateChartsData.august,
                        candidateChartsData.september, candidateChartsData.october,
                        candidateChartsData.november, candidateChartsData.december
                    ]
                }, {
                    label: '{{__("Client")}}',
                    backgroundColor: "#a2995e",
                    data: [
                        clientChartsData.january, clientChartsData.february,
                        clientChartsData.march, clientChartsData.april,
                        clientChartsData.may, clientChartsData.june,
                        clientChartsData.july, clientChartsData.august,
                        clientChartsData.september, clientChartsData.october,
                        clientChartsData.november, clientChartsData.december
                    ]
                }, {
                    label: '{{__("Contact")}}',
                    backgroundColor: "#312e20",
                    data: [
                        contactChartsData.january, contactChartsData.february,
                        contactChartsData.march, contactChartsData.april,
                        contactChartsData.may, contactChartsData.june,
                        contactChartsData.july, contactChartsData.august,
                        contactChartsData.september, contactChartsData.october,
                        contactChartsData.november, contactChartsData.december
                    ]
                }
            ]
        },
        options: {
            title: {
                display: true,
                text: '{{__("Current Year Statistic Chart")}}'
            },
            legend: {
                position: 'bottom'
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
</script>
