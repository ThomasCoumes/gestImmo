/**
 * Created by thocou on 21/03/19.
 */
import Chart from 'chart.js'

let ctx = document.getElementById('rentResumeChart').getContext('2d');

let propertyName = document.getElementsByClassName('propertyName');
let propertyRent = document.getElementsByClassName('propertyRent');
let date = document.getElementsByClassName('currentDate')[0].innerHTML;

let propertyNameList = [];
let propertyRentList = [];
let count = -1;

for (let property in propertyName) {
    count = ++count;
    if (count in propertyName) {
        propertyNameList[count] = propertyName.item(count).innerText;
    }
}

let totalLabel = propertyNameList.length + 1;
propertyNameList[totalLabel] = 'Total';

count = -1;
for (let property in propertyRent) {
    count = ++count;
    if (count in propertyRent) {
        propertyRentList[count] = propertyRent.item(count).innerText;
    }
}

let total = 0;
for (let i = 0; i<propertyRentList.length; i++) {
    propertyRentList[i] = parseFloat(propertyRentList[i]);
    total = total + propertyRentList[i];
}

let totalIndex = propertyRent.length + 1;
propertyRentList[totalIndex] = total;

let rentResumeChart = new Chart(ctx, {
    responsive: true,
    maintainAspectRatio: false,
    type: 'bar',
    data: {
        labels: propertyNameList,
        datasets: [{
            label: 'Revenus par propriétée en ' .concat(date) .concat(' en €'),
            data: propertyRentList,
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
