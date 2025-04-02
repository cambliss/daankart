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
<div class="container py-4 upcomming-events">
    <div class="row">

        <!-- Upcoming Events -->
        <div class="col-md-6">
            <h4 class="mb-4">Upcoming Event</h4>
            <!-- Event Slider -->
            <div id="eventCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @foreach ($events as $key => $event)
                    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                        <div class="card border-0 shadow-sm">
                            <div class="position-relative image-container">
                                <img src="{{ $cause->image ?? 'https://via.placeholder.com/500x300.png?text=Event+Image' }}" class="card-img-top rounded-top"
                                alt="Event Image">
                                <div class="event-date position-absolute top-0 start-0 m-3">
                                    <div class="day">{{ $event->day }}</div>
                                    <div class="month">{{ $event->month }}</div>
                                </div>
                            </div>
                            <div class="card-body">
                                <h5 class="text-danger mb-2">{{ $event->title }}</h5>
                                <p class="mb-1"><small><i class="bi bi-clock"></i> {{ $event->start_date }} - {{ $event->end_date }}</small></p>
                                <p class="text-muted small">{{ $event->donation }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#eventCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#eventCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>

        <!-- Featured Causes -->
        <div class="col-md-6">
            <h4 class="mb-4">Featured Causes</h4>
            @foreach ($featuredCauses as $cause)
            <div class="card border-0 shadow-sm">
                <div class="position-relative image-container" >
                    <img src="{{ $cause->image }}" class="card-img-top rounded-top"
                    alt="Child Image">
                    <div class="donation-bar">{{ $cause->raised }} donated of {{ $cause->goal }} goal</div>
                </div>
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

@push('style')
<style>
    .event-date {
      background-color: #ff4a00;
      color: white;
      text-align: center;
      padding: 10px;
      width: 60px;
      border-radius: 5px;
    }
    .event-date .day {
      font-size: 1.25rem;
      font-weight: bold;
    }
    .event-date .month {
      text-transform: uppercase;
    }
    .donation-bar {
      background: rgba(255, 74, 0, 0.85);
      color: white;
      text-align: center;
      padding: 10px;
      border-bottom-left-radius: 0.5rem;
      border-bottom-right-radius: 0.5rem;
      width: 100%;
      position: absolute;
      bottom: 0;
      left: 0;
    }
    .social-icons i {
      font-size: 1.2rem;
      margin-right: 10px;
      color: #ff4a00;
      cursor: pointer;
    }
    .upcomming-events .image-container {
        height: 250px;
        overflow: hidden;
    }
</style>
@endpush
