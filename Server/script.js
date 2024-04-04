document.addEventListener("DOMContentLoaded", function () {
    const humidityRing = document.getElementById('humidity-ring');
    const progressCircle = humidityRing.querySelector('.progress');
    const humidityPercentage = humidityRing.getAttribute('data-humidity');
    const circumference = parseFloat(progressCircle.getAttribute('stroke-dasharray'));
    const offset = circumference - (humidityPercentage / 100) * circumference;

    progressCircle.style.strokeDashoffset = offset;
    document.getElementById('humidity-percentage').innerText = `${humidityPercentage}%`;
});
