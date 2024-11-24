export let calendar;

document.addEventListener('DOMContentLoaded', function() {
    let calendarEl = document.getElementById('calendar');
    calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'timeGridWeek',
            hiddenDays: [0],
            locale: 'fr',
            firstDay: 1,
            events: [],
            headerToolbar: {
                start: 'prev,next today',
                center: 'title',
                end: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
        }
    );
    calendar.render();
});
