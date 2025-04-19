<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MEDBook - Doctor Schedule</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>


<style>
    body {
        background-color: #121212;
        min-height: 100vh;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        color: white;
    }

    .med-teal {
        color: #00CCCC;
    }

    /* FullCalendar Toolbar */
    .fc .fc-toolbar-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: white;
    }

    .fc-toolbar.fc-header-toolbar {
        margin-bottom: 1rem;
    }

    .fc-button {
        background-color: #4a5568;
        color: white;
        border: none;
        padding: 0.25rem 0.75rem;
        border-radius: 0.375rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        transition: background-color 0.3s ease;
        font-weight: 500;
    }

    .fc-button:hover {
        background-color: #2d3748;
    }

    .fc-button-primary:not(:disabled).fc-button-active,
    .fc-button-primary:not(:disabled):active,
    .fc-button-primary:hover {
        background-color: #00CCCC;
        border-color: #00CCCC;
        box-shadow: 0 4px 10px rgba(0, 204, 204, 0.3);
    }

    .fc-event {
        font-size: 0.875rem;
        padding: 0.25rem 0.5rem;
        border-radius: 6px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        cursor: pointer;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        border: none;
    }

    .fc-event:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .fc-event-confirmed {
        background-color: rgba(16, 185, 129, 0.85);
        color: white;
    }

    .fc-event-pending {
        background-color: rgba(245, 158, 11, 0.85);
        color: white;
    }

    .fc-event-cancelled {
        background-color: rgba(239, 68, 68, 0.85);
        color: white;
    }

    .fc-event-completed {
        background-color: rgba(59, 130, 246, 0.85);
        color: white;
    }

    .fc-daygrid-day {
        background: rgba(40, 40, 40, 0.4);
        transition: background-color 0.2s ease;
    }

    .fc-daygrid-day:hover {
        background: rgba(50, 50, 50, 0.6);
    }

    .fc .fc-col-header-cell {
        background-color: rgba(30, 30, 30, 0.8);
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }

    .fc .fc-col-header-cell-cushion {
        color: #eeeeee;
        font-weight: 600;
        text-decoration: none;
        padding: 8px;
    }

    .fc .fc-daygrid-day.fc-day-today {
        background-color: rgba(0, 204, 204, 0.1);
    }

    .fc {
        font-family: inherit;
    }

    /* Buttons */
    .btn-teal {
        background-color: #00CCCC;
        color: white;
        transition: all 0.3s ease;
    }

    .btn-teal:hover {
        box-shadow: 0 4px 15px rgba(0, 204, 204, 0.5);
        transform: translateY(-2px);
    }

    /* Cards */
    .card {
        background: rgba(40, 40, 40, 0.7);
        border: 1px solid rgba(255, 255, 255, 0.05);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        transition: all 0.4s ease;
        border-radius: 16px;
        backdrop-filter: blur(10px);
    }

    .card:hover {
        box-shadow: 0 15px 40px rgba(0, 204, 204, 0.15);
        transform: translateY(-5px);
    }

    /* Sidebar */
    .sidebar-link {
        display: flex;
        align-items: center;
        padding: 12px 24px;
        border-radius: 8px;
        margin-bottom: 8px;
        transition: all 0.3s ease;
    }

    .sidebar-link:hover,
    .sidebar-link.active {
        background-color: rgba(0, 204, 204, 0.1);
    }

    .sidebar-link.active {
        border-left: 3px solid #00CCCC;
    }

    /* Logo Pulse */
    .logo-pulse {
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% {
            text-shadow: 0 0 5px rgba(0, 204, 204, 0.5);
        }
        50% {
            text-shadow: 0 0 20px rgba(0, 204, 204, 0.8);
        }
        100% {
            text-shadow: 0 0 5px rgba(0, 204, 204, 0.5);
        }
    }

    /* Status badge */
    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 9999px;
        font-size: 0.875rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    }

    /* Modal */
    .modal {
        display: none;
        position: fixed;
        z-index: 100;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
        animation: fadeIn 0.3s ease;
        backdrop-filter: blur(5px);
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .modal-content {
        background: rgba(40, 40, 40, 0.95);
        margin: 10% auto;
        padding: 30px;
        border-radius: 16px;
        width: 90%;
        max-width: 500px;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
        border: 1px solid rgba(255, 255, 255, 0.1);
        transform: translateY(20px);
        animation: slideIn 0.4s forwards;
        backdrop-filter: blur(10px);
    }

    @keyframes slideIn {
        to { transform: translateY(0); }
    }

    .close-modal {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
        transition: color 0.2s ease;
    }

    .close-modal:hover {
        color: #00CCCC;
    }

    /* Scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }

    ::-webkit-scrollbar-track {
        background: rgba(30, 30, 30, 0.5);
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb {
        background: rgba(0, 204, 204, 0.5);
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: rgba(0, 204, 204, 0.8);
    }

    /* Stat cards */
    .stat-card {
        overflow: hidden;
        position: relative;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(0, 204, 204, 0.1) 0%, rgba(0, 0, 0, 0) 60%);
        z-index: 0;
        opacity: 0;
        transition: opacity 0.4s ease;
    }

    .stat-card:hover::before {
        opacity: 1;
    }

    .icon-container {
        transition: all 0.3s ease;
    }

    .stat-card:hover .icon-container {
        transform: scale(1.2);
    }

    /* Tooltip */
    .tooltip {
        position: relative;
        display: inline-block;
    }

    .tooltip .tooltiptext {
        visibility: hidden;
        width: 120px;
        background-color: rgba(30, 30, 30, 0.9);
        color: #fff;
        text-align: center;
        border-radius: 6px;
        padding: 5px;
        position: absolute;
        z-index: 1;
        bottom: 125%;
        left: 50%;
        margin-left: -60px;
        opacity: 0;
        transition: opacity 0.3s;
        font-size: 12px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        backdrop-filter: blur(5px);
    }

    .tooltip:hover .tooltiptext {
        visibility: visible;
        opacity: 1;
    }
</style>

</head>
<body class="text-gray-100 min-h-screen">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-gray-900 p-6 flex flex-col">
            <div class="mb-10">
                <a href="#" class="flex items-center">
                    <span class="med-teal text-3xl font-bold logo-pulse">MED</span><span class="text-3xl font-bold text-white">Book</span>
                </a>
                <p class="text-gray-400 text-xs mt-2">Healthcare Management System</p>
            </div>
            <nav class="flex-1">
                <a href="{{route('doctor.dashboard')}}" class="sidebar-link">
                    <svg class="h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Dashboard
                </a>
                <a href="{{route('doctor.appointments')}}" class="sidebar-link">
                    <svg class="h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    My Appointments
                </a>
                <a href="#" class="sidebar-link active">
                    <svg class="h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    My Schedule
                </a>
                <a href="{{route('doctor.patients')}}" class="sidebar-link">
                    <svg class="h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    My Patients
                </a>
<a href="{{ route('profile.view') }}" class="sidebar-link">
                    <svg class="h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Profile
                </a>
            </nav>
            <div class="mt-auto pt-6 border-t border-gray-800">
            <div class="flex items-center">
    @if($user->profile_picture)
        <img src="{{ asset('storage/' . $user->profile_picture) }}"
             alt="Profile Picture"
             class="h-10 w-10 rounded-full object-cover" />
    @else
        <div class="h-10 w-10 rounded-full bg-gray-700 flex items-center justify-center text-white font-semibold">
            Dr
        </div>
    @endif

    <div class="ml-3">
        <div class="font-medium">Dr. {{ $user->name }}</div>
        <div class="text-sm text-gray-400">Doctor</div>
    </div>
</div>
               <form action="{{ route('logout') }}" method="POST" class="mt-4">
                    @csrf
                    <button type="submit" class="w-full btn-teal py-2 rounded-lg text-sm font-medium flex items-center justify-center mt-4 group">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-8">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-bold">My Schedule</h1>
                    <p class="text-gray-400 mt-1">Manage your appointments and schedules efficiently</p>
                </div>

            </div>

            <!-- Status Overview -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="card p-6 stat-card">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-400 text-sm">Total Appointments</p>
                            <h3 class="text-2xl font-bold mt-1" id="totalAppointments">0</h3>
                            <p class="text-xs text-gray-500 mt-1">This month</p>
                        </div>
                        <div class="h-12 w-12 bg-blue-500 bg-opacity-20 rounded-full flex items-center justify-center icon-container">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="card p-6 stat-card">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-400 text-sm">Upcoming</p>
                            <h3 class="text-2xl font-bold mt-1" id="upcomingAppointments">0</h3>
                            <p class="text-xs text-green-400 mt-1">Ready to attend</p>
                        </div>
                        <div class="h-12 w-12 bg-green-500 bg-opacity-20 rounded-full flex items-center justify-center icon-container">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="card p-6 stat-card">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-400 text-sm">Pending</p>
                            <h3 class="text-2xl font-bold mt-1" id="pendingAppointments">0</h3>
                            <p class="text-xs text-yellow-400 mt-1">Awaiting confirmation</p>
                        </div>
                        <div class="h-12 w-12 bg-yellow-500 bg-opacity-20 rounded-full flex items-center justify-center icon-container">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="card p-6 stat-card">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-400 text-sm">Completed</p>
                            <h3 class="text-2xl font-bold mt-1" id="completedAppointments">0</h3>
                            <p class="text-xs text-purple-400 mt-1">Successfully attended</p>
                        </div>
                        <div class="h-12 w-12 bg-purple-500 bg-opacity-20 rounded-full flex items-center justify-center icon-container">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Calendar -->
            <div class="card p-6 overflow-hidden">
                <div id="calendar"></div>
            </div>
        </div>
    </div>

    <!-- Appointment Detail Modal -->
    <div id="appointmentModal" class="modal">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <h2 class="text-2xl font-bold mb-4">Appointment Details</h2>
            <div id="appointmentDetails">
                <div class="mb-4">
                    <p class="text-gray-400 text-sm">Patient Name</p>
                    <p class="text-lg font-medium" id="modalPatientName">-</p>
                </div>
                <div class="mb-4">
                    <p class="text-gray-400 text-sm">Date & Time</p>
                    <p class="text-lg font-medium" id="modalDateTime">-</p>
                </div>
                <div class="mb-4">
                    <p class="text-gray-400 text-sm">Duration</p>
                    <p class="text-lg font-medium" id="modalDuration">-</p>
                </div>
                <div class="mb-6">
                    <p class="text-gray-400 text-sm">Status</p>
                    <div class="mt-2" id="modalStatus">-</div>
                </div>
                <div class="mb-6">
                    <p class="text-gray-400 text-sm">Notes</p>
                    <p class="text-gray-300 mt-1 text-sm" id="modalNotes">No notes available for this appointment.</p>
                </div>
                <div class="flex space-x-3">

                    <button id="viewPatientBtn" class="bg-gray-700 hover:bg-gray-600 py-2 px-4 rounded-lg text-sm font-medium flex-1 flex items-center justify-center transition-all duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        View Patient
                    </button>
                </div>
            </div>
        </div>
    </div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get the events data from PHP
    const eventsData = @json($events);

    let totalCount = eventsData.length;
    let pendingCount = 0;
    let confirmedCount = 0;
    let completedCount = 0;

    const formattedEvents = eventsData.map(event => {
        const status = event.status;
        let color;

        switch (status) {
            case 'booked':
                color = 'fc-event-confirmed';
                confirmedCount++;
                break;
            case 'pending':
                color = 'fc-event-pending';
                pendingCount++;
                break;
            case 'completed':
                color = 'fc-event-completed';
                completedCount++;
                break;
            default:
                console.warn("Unrecognized status:", status);
                color = 'fc-event-pending';
        }

        return {
            ...event,
            classNames: [color]
        };
    });

    // Update the stats with animation
    animateCounter('totalAppointments', 0, totalCount);
    animateCounter('upcomingAppointments', 0, confirmedCount);
    animateCounter('pendingAppointments', 0, pendingCount);
    animateCounter('completedAppointments', 0, completedCount);

    // Initialize the calendar

const calendarEl = document.getElementById('calendar');
const calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth', // Default view is the month grid
    headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay'
    },
    events: formattedEvents,
    eventClick: function(info) {
        showAppointmentDetails(info.event);
    },
    height: 'auto',
    contentHeight: 'auto',
    aspectRatio: 2,
    dayMaxEvents: true,
    eventTimeFormat: {
        hour: '2-digit',
        minute: '2-digit',
        meridiem: false
    },
    eventDidMount: function(info) {
        info.el.style.transition = "all 0.3s ease";
    },
    // Views specific configuration
    views: {
        timeGridDay: {
            slotMinTime: '08:00:00', // Limit the start time to 6 AM
            slotMaxTime: '18:00:00', // Limit the end time to 6 PM
        },
        timeGridWeek: {
            slotMinTime: '08:00:00', // Limit the start time to 6 AM
            slotMaxTime: '18:00:00', // Limit the end time to 6 PM
        }
    }
});
calendar.render();
    // Counter animation function
    function animateCounter(id, start, end) {
        let current = start;
        const element = document.getElementById(id);
        const duration = 1000;
        const steps = 20;
        const increment = (end - start) / steps;
        const stepTime = duration / steps;

        const timer = setInterval(function() {
            current += increment;
            if (current >= end) {
                current = end;
                clearInterval(timer);
            }
            element.textContent = Math.round(current);
        }, stepTime);
    }

    // Modal handling
    const modal = document.getElementById('appointmentModal');
    const closeBtn = document.getElementsByClassName('close-modal')[0];

    closeBtn.onclick = function() {
        modal.style.display = "none";
    };

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    };

    // Show appointment details in modal
    function showAppointmentDetails(event) {
        const startTime = new Date(event.start);
        const endTime = new Date(event.end);
        const duration = Math.round((endTime - startTime) / (1000 * 60));

        document.getElementById('modalPatientName').textContent = event.title;
        document.getElementById('modalDateTime').textContent = startTime.toLocaleString('en-US', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: 'numeric',
            minute: 'numeric',
            hour12: true
        });
        document.getElementById('modalDuration').textContent = `${duration} minutes`;

        // Set status badge
        const statusBadge = document.createElement('span');
        statusBadge.className = 'status-badge';

        switch(event.extendedProps.status) {
            case 'booked':
                statusBadge.className += ' bg-green-500 bg-opacity-20 text-green-500';
                statusBadge.innerHTML = '<i class="fas fa-check-circle mr-2"></i>Booked';
                break;
            case 'pending':
                statusBadge.className += ' bg-yellow-500 bg-opacity-20 text-yellow-500';
                statusBadge.innerHTML = '<i class="fas fa-clock mr-2"></i>Pending';
                break;
            case 'completed':
                statusBadge.className += ' bg-blue-500 bg-opacity-20 text-blue-500';
                statusBadge.innerHTML = '<i class="fas fa-check-double mr-2"></i>Completed';
                break;
            default:
                statusBadge.className += ' bg-gray-500 bg-opacity-20 text-gray-400';
                statusBadge.innerHTML = '<i class="fas fa-question-circle mr-2"></i>Unknown';
        }

        const statusContainer = document.getElementById('modalStatus');
        statusContainer.innerHTML = '';
        statusContainer.appendChild(statusBadge);

        // Add notes if available
        if (event.extendedProps.notes) {
            document.getElementById('modalNotes').textContent = event.extendedProps.notes;
        } else {
            document.getElementById('modalNotes').textContent = 'No notes available for this appointment.';
        }

        // Set patient ID for the button
        const patientId = event.extendedProps.patient_id || '0';
        document.getElementById('viewPatientBtn').setAttribute('data-patient-id', patientId);

        // Show the modal
        modal.style.display = "block";
    }

    // Attach viewPatientBtn event listener once
    document.getElementById('viewPatientBtn').addEventListener('click', function() {
        const patientId = this.getAttribute('data-patient-id');
        if (patientId !== '0') {
            window.location.href = `/doctor/patient/${patientId}`;
        } else {
            alert("Invalid patient ID");
        }
    });

    // Add keyboard navigation for modal
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape' && modal.style.display === 'block') {
            modal.style.display = 'none';
        }
    });
});
</script>
</body>
</html>
