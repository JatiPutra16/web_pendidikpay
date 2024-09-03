const days = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"]; 

function showClock() {
    const now = new Date();
    const dayName = days[now.getDay()];
    const hour = now.getHours().toString().padStart(2, '0');
    const minute = now.getMinutes().toString().padStart(2, '0');
    const second = now.getSeconds().toString().padStart(2, '0');

    document.getElementById('day').textContent = dayName;
    document.getElementById('hour').textContent = hour;
    document.getElementById('min').textContent = minute;
    document.getElementById('second').textContent = second;
}

setInterval(showClock, 1000);
showClock(); 
