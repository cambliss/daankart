@php
    $events = [
        (object)[
            'day' => 12,
            'month' => 'Jan',
            'title' => 'Charity For Education',
            'start_date' => '08:00 AM',
            'end_date' => '03:00 PM',
            'donation' => 'There are many variations of lorem passage of lorem ipsum available. Donate Now.'
        ],
        (object)[
            'day' => 12,
            'month' => 'Jan',
            'title' => 'Charity For Education',
            'start_date' => '08:00 AM',
            'end_date' => '03:00 PM',
            'donation' => 'There are many variations of lorem passage of lorem ipsum available. Donate Now.'
        ],
        (object)[
            'day' => 12,
            'month' => 'Jan',
            'title' => 'Charity For Education',
            'start_date' => '08:00 AM',
            'end_date' => '03:00 PM',
            'donation' => 'There are many variations of lorem passage of lorem ipsum available. Donate Now.'
        ],
    ];
    $featuredCauses = [
        (object)[
            'title' => 'Charity For Education',
            'donation' => 'There are many variations of lorem passage of lorem ipsum available. Donate Now.',
            'image' => 'https://via.placeholder.com/500x300.png?text=Child+Smiling',
            'goal' => '18,900.00',
            'raised' => '3,720.00',
        ],
    ];
@endphp
<div class="container py-4">
    <div class="row">

        <!-- Upcoming Events -->
        <div class="col-md-6">
            <h4 class="mb-4">Upcoming Event</h4>
            <!-- Event Item -->
            @foreach ($events as $event)
            <div class="d-flex mb-3">
                <div class="event-date me-3">
                    <div class="day">{{ $event->day }}</div>
                    <div class="month">{{ $event->month }}</div>
                </div>
                <div>
                    <h6 class="text-danger mb-1">{{ $event->title }}</h6>
                    <p class="mb-0"><small>{{ $event->start_date }} - {{ $event->end_date }}</small></p>
                    <p class="text-muted small">Donation: {{ $event->donation }}</p>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Featured Causes -->
        <div class="col-md-6">
            <h4 class="mb-4">Featured Causes</h4>
            @foreach ($featuredCauses as $cause)
            <div class="card border-0 shadow-sm">
                <img src="{{ $cause->image }}" class="card-img-top rounded-top"
                    alt="Child Image">
                <div class="donation-bar">{{ $cause->raised }} donated of {{ $cause->goal }} goal</div>
                <div class="card-body">
                    <h5 class="card-title text-danger">{{ $cause->title }}</h5>
                    <p class="card-text text-muted small">
                        {{ $cause->donation }}
                    </p>
                    <div class="mb-2">
                        <button class="btn btn-sm btn-danger me-2">Donate Now</button>
                        <button class="btn btn-sm btn-outline-danger">Read More</button>
                    </div>
                    <div class="social-icons mt-2">
                        <i class="bi bi-facebook"></i>
                        <i class="bi bi-twitter"></i>
                        <i class="bi bi-instagram"></i>
                        <i class="bi bi-share-fill"></i>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
