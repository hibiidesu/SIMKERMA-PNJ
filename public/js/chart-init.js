const chartData = new Chart(
    document.querySelector("#chart-data .canvas-chart").getContext("2d"),
    {
        type: "bar",
        data: {
            datasets: [
                {
                    borderWidth: 1,
                },
            ],
        },
        options: {
            plugins: {
                responsive: true,
                barRoundness: 1,
                title: {
                    display: false,
                    text: "",
                },
                legend: {
                    display: false,
                },
                scales: {
                    yAxes: [
                        {
                            ticks: {
                                beginAtZero: true,
                                suggestedMax: 40 + 20,
                                padding: 10,
                            },
                            gridLines: {
                                drawBorder: false,
                            },
                        },
                    ],
                    xAxes: [
                        {
                            gridLines: {
                                display: false,
                                drawBorder: false,
                            },
                        },
                    ],
                },
            },
        },
    }
);
const chartBySifat = new Chart(
    document.querySelector("#chart-by-sifat .canvas-chart").getContext("2d"),
    {
        type: "bar",
        data: {
            datasets: [
                {
                    borderWidth: 1,
                },
            ],
        },
        options: {
            plugins: {
                responsive: true,
                barRoundness: 1,
                title: {
                    display: false,
                    text: "",
                },
                legend: {
                    display: false,
                },
                scales: {
                    yAxes: [
                        {
                            ticks: {
                                beginAtZero: true,
                                suggestedMax: 40 + 20,
                                padding: 10,
                            },
                            gridLines: {
                                drawBorder: false,
                            },
                        },
                    ],
                    xAxes: [
                        {
                            gridLines: {
                                display: false,
                                drawBorder: false,
                            },
                        },
                    ],
                },
            },
        },
    }
);
const chartBySifatYear = new Chart(
    document
        .querySelector("#chart-by-sifat-year .canvas-chart")
        .getContext("2d"),
    {
        options: {
            plugins: {
                responsive: true,
                barRoundness: 1,
                title: {
                    display: false,
                    text: "",
                },
                legend: {
                    display: true,
                },
                scales: {
                    yAxes: [
                        {
                            ticks: {
                                beginAtZero: true,
                                suggestedMax: 40 + 20,
                                padding: 10,
                            },
                            gridLines: {
                                drawBorder: false,
                            },
                        },
                    ],
                    xAxes: [
                        {
                            gridLines: {
                                display: false,
                                drawBorder: false,
                            },
                        },
                    ],
                },
            },
        },
    }
);
const chartByJenisYear = new Chart(
    document
        .querySelector("#chart-by-jenis-year .canvas-chart")
        .getContext("2d"),
    {
        options: {
            plugins: {
                responsive: true,
                barRoundness: 1,
                title: {
                    display: false,
                    text: "",
                },
                legend: {
                    display: true,
                },
                scales: {
                    yAxes: [
                        {
                            ticks: {
                                beginAtZero: true,
                                suggestedMax: 40 + 20,
                                padding: 10,
                            },
                            gridLines: {
                                drawBorder: false,
                            },
                        },
                    ],
                    xAxes: [
                        {
                            gridLines: {
                                display: false,
                                drawBorder: false,
                            },
                        },
                    ],
                },
            },
        },
    }
);
const chartByJenisKerjasama = new Chart(
    document
        .querySelector("#chart-by-jenis-kerjasama .canvas-chart")
        .getContext("2d"),
    {
        type: "bar",
        data: {
            datasets: [
                {
                    borderWidth: 1,
                },
            ],
        },
        options: {
            plugins: {
                responsive: true,
                barRoundness: 1,
                title: {
                    display: false,
                    text: "",
                },
                legend: {
                    display: false,
                },
                scales: {
                    yAxes: [
                        {
                            ticks: {
                                beginAtZero: true,
                                suggestedMax: 40 + 20,
                                padding: 10,
                            },
                            gridLines: {
                                drawBorder: false,
                            },
                        },
                    ],
                    xAxes: [
                        {
                            gridLines: {
                                display: false,
                                drawBorder: false,
                            },
                        },
                    ],
                },
            },
        },
    }
);
const chartByUnit = new Chart(
    document.querySelector("#chart-by-unit .canvas-chart").getContext("2d"),
    {
        type: "bar",
        data: {
            datasets: [
                {
                    borderWidth: 1,
                },
            ],
        },
        options: {
            plugins: {
                responsive: true,
                barRoundness: 1,
                title: {
                    display: false,
                    text: "",
                },
                legend: {
                    display: false,
                },
                scales: {
                    yAxes: [
                        {
                            ticks: {
                                beginAtZero: true,
                                suggestedMax: 40 + 20,
                                padding: 10,
                            },
                            gridLines: {
                                drawBorder: false,
                            },
                        },
                    ],
                    xAxes: [
                        {
                            gridLines: {
                                display: false,
                                drawBorder: false,
                            },
                        },
                    ],
                },
            },
        },
    }
);
const chartByMemorandum = new Chart(
    document
        .querySelector("#chart-by-memorandum .canvas-chart")
        .getContext("2d"),
    {
        type: "bar",
        data: {
            datasets: [
                {
                    borderWidth: 1,
                },
            ],
        },
        options: {
            plugins: {
                responsive: true,
                barRoundness: 1,
                title: {
                    display: false,
                    text: "",
                },
                legend: {
                    display: false,
                },
                scales: {
                    yAxes: [
                        {
                            ticks: {
                                beginAtZero: true,
                                suggestedMax: 40 + 20,
                                padding: 10,
                            },
                            gridLines: {
                                drawBorder: false,
                            },
                        },
                    ],
                    xAxes: [
                        {
                            gridLines: {
                                display: false,
                                drawBorder: false,
                            },
                        },
                    ],
                },
            },
        },
    }
);
