<template>
    <div class="mb-4">
        <canvas id="projectChart"></canvas>
    </div>
</template>

<script setup>
import Chart from 'chart.js/auto'
import {onMounted} from "vue";

function formatDate(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;

    return [year, month, day].join('-');
}

onMounted(() => {
    let ctx = document.getElementById('projectChart')
    let today = new Date()
    let dates = []
    let data = []
    for (let i = 0; i < 10; i++) {
        dates.push(formatDate(today.setDate(today.getDate()-i)))
        data.push(Math.floor((Math.random() * 20) + i))
    }
    
    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: dates,
            datasets: [{
                label: 'Project Inserted',
                data: data
            }]
        }
    });
})


 


</script>