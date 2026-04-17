@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto mt-6">
    <!-- Judul + Legend -->
    <div class="flex items-center justify-between mb-4">
        <!-- Judul -->
        <h1 class="text-xl font-semibold text-slate-800">
            Jadwal Belajar TPQ
        </h1>

        <!-- Legend -->
        <div class="flex items-center gap-3 text-xs text-gray-600">
            <div class="flex items-center gap-1">
                <span class="w-3 h-3 rounded-full bg-green-500 inline-block"></span>
                Mengaji
            </div>
            <div class="flex items-center gap-1">
                <span class="w-3 h-3 rounded-full bg-red-500 inline-block"></span>
                Libur
            </div>
        </div>
    </div>

    <!-- Kalender -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5">
        <div id="calendar" class="w-full"></div>
    </div>

</div>

<!-- Modal Pilih Status -->
<div id="statusModal" class="fixed inset-0 hidden items-center justify-center z-50">
    <div class="absolute inset-0 bg-black opacity-40"></div>
    <div class="bg-white rounded-lg p-6 z-50 w-80 relative">
        <h2 class="text-lg font-semibold mb-4 text-center">Pilih Status</h2>
        <div class="flex justify-between">
            <button id="btnMengaji" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">Mengaji</button>
            <button id="btnLibur" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">Libur</button>
        </div>
        <button id="btnClose" class="mt-4 text-sm text-gray-500 hover:underline block mx-auto">Batal</button>
    </div>
</div>
@endsection

@push('scripts')
<script>
    window.userRole = "{{ auth()->user()->role }}";
</script>
<script>
    const userRole = "{{ auth()->user()->role }}";
</script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>

<!-- Tippy.js untuk tooltip -->
<link rel="stylesheet" href="https://unpkg.com/tippy.js@6/dist/tippy.css">
<script src="https://unpkg.com/@popperjs/core@2"></script>
<script src="https://unpkg.com/tippy.js@6"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('calendar');
        const modal = document.getElementById('statusModal');
        let selectedDate = null;

        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            height: 'auto',
            locale: 'id',
            selectable: true,
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
            },
            events: '/informasi/jadwal/get',
            dateClick: function(info) {

                if (userRole === 'viewer') {
                    return; // viewer tidak boleh edit
                }

                selectedDate = info.dateStr;
                modal.classList.remove('hidden');
            },
            eventDidMount: function(info) {
                tippy(info.el, {
                    content: info.event.title,
                    placement: 'top',
                    theme: 'light-border'
                });
            }
        });

        calendar.render();

        document.getElementById('btnMengaji').addEventListener('click', () => saveStatus('mengaji'));
        document.getElementById('btnLibur').addEventListener('click', () => saveStatus('libur'));
        document.getElementById('btnClose').addEventListener('click', () => {
            modal.classList.add('hidden');
            selectedDate = null;
        });

        function saveStatus(status) {
            if (userRole === 'viewer') {
                alert('Jadwal hanya dapat diubah oleh Admin.');
                return;
            }
            if (!selectedDate) return;

            fetch('/informasi/jadwal/update', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        tanggal: selectedDate,
                        status: status
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        calendar.refetchEvents();
                    } else {
                        alert('Gagal menyimpan jadwal!');
                    }
                    modal.classList.add('hidden');
                    selectedDate = null;
                })
                .catch(err => {
                    alert('Terjadi error!');
                    modal.classList.add('hidden');
                    selectedDate = null;
                });
        }
    });
</script>
@endpush