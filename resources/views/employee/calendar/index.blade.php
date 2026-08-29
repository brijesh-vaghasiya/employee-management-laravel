@extends('layouts.employee')

@push('styles')
<!-- FullCalendar CSS -->
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
<style>
    #calendar {
        background: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        min-height: 600px;
    }
    .fc-event {
        cursor: pointer;
    }
</style>
@endpush

@section('content')
<div class="row mb-4 align-items-center flex-row">
    <div class="col">
        <h3 class="mb-0 text-dark fw-bold"><i class="bi bi-calendar-range text-primary me-2"></i> My Calendar</h3>
        <p class="text-muted small">Track your personal Leaves, Team Birthdays, and Holidays.</p>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div id='calendar'></div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var eventsData = {!! json_encode($events) !!};

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,listMonth'
            },
            themeSystem: 'bootstrap5',
            events: eventsData,
            eventClick: function(info) {
                alert('Event: ' + info.event.title);
            }
        });
        
        calendar.render();
    });
</script>
@endpush
