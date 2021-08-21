const ctx = document.querySelector('#studyProgressChart');

let credits = ctx.dataset.credits;
let availableCredits = ctx.dataset.availableCredits - credits;

const data = {
    datasets: [{
        data: [credits, availableCredits],
        backgroundColor: [
            '#7eff7a',
            '#ffbd6b'
        ]
    }],
    labels: [
        'achieved',
        'available'
    ]
};
const options = {
    legend: {
        display: false
    }
};

new Chart(ctx, {
    type: 'pie',
    data: data,
    options: options
});
