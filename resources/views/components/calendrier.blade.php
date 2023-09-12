<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8' />
    <link href='{{ asset('packages/fullcalendar/core/main.css') }}' rel='stylesheet' />
    <link href='{{ asset('packages/fullcalendar/daygrid/main.css') }}' rel='stylesheet' />
    <link href='{{ asset('packages/fullcalendar/timegrid/main.css') }}' rel='stylesheet' />
    <script src='{{ asset('packages/fullcalendar/core/main.js') }}'></script>
    <script src='{{ asset('packages/fullcalendar/daygrid/main.js') }}'></script>
    <script src='{{ asset('packages/fullcalendar/timegrid/main.js') }}'></script>
    <script src='{{ asset('packages/fullcalendar/list/main.js') }}'></script>
</head>
<body>
    <div id='calendar'></div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                plugins: ['dayGrid', 'timeGrid', 'list'],
                locale: 'fr', // Set locale to French
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                },
                events: [
                    // Add your events here
                ]
            });

            calendar.render();
        });
    </script>
</body>
</html>