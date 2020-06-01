@if(!$student->todayAttendance)
    ―
@else
    <div class="registration-status {{ $student->todayAttendance->type === 'attendance' ? 'registration-status--circle' : 'registration-status--cross' }}" style="transform: translateY(2px);"></div> <span>ー {{ $student->todayAttendance->content }}</span>
@endif
