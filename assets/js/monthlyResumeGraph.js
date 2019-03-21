/**
 * Created by thocou on 21/03/19.
 */
import Chart from 'chart.js'

let ctx = document.getElementById('rentResumeChart').getContext('2d');

let rentResumeChart = new Chart(ctx, {
    responsive: true,
    maintainAspectRatio: false,
    type: 'bar',
    data: {
        labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
        datasets: [{
            label: 'Revenus par propriétée en date en €',
            data: [12, 19, 3, 5, 2, 3],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true,
                    fontSize: 25,
                    fontStyle: 'bold',
                }
            }],
            xAxes: [{
                ticks: {
                    fontSize: 25,
                    fontStyle: 'bold',
                }
            }],
        },
        legend: {
            labels: {
                fontSize: 40,
                fontStyle: 'bold',
            }
        }
    },
});
