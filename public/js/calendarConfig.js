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
            eventClick: function(info) {
                Swal.fire({
                    title:  "Détail de la consultation",
                    text: info.event.title,
                    icon: "info",
                    returnFocus: false,
                });
            }
        }
    );
    calendar.render();
});

export function addEventSource(events) {
    calendar.addEventSource(events);
}