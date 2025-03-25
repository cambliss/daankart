
<style>
    :root {
        --carousel-width: 800px;
    }
    .carousel-cover {
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
        top: 2vh;
        display: none;
    }
    .carousel-container {
        width: var(--carousel-width);
        overflow: hidden;
        position: relative;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    .carousel-track {
        display: flex;
        transition: transform 1s ease-in-out;
    }

    .card {
        display: flex;
        background-color: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        width: var(--carousel-width);
        flex-shrink: 0;
        flex-direction: row;
    }

    .card img {
        width: 30%;
        object-fit: cover;
        height: auto;
        margin: 10px;
        border-radius: 10px;
    }

    .card-content {
        padding: 15px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .badge {
        background-color: #5a4caf;
        color: #fff;
        padding: 5px 10px;
        border-radius: 15px;
        font-weight: bold;
        width: fit-content;
        margin-bottom: 10px;
    }

    .title {
        font-weight: bold;
        font-size: 18px;
        margin-bottom: 5px;
    }

    .description {
        color: #6b7280;
        font-size: 14px;
    }

    .donate-button {
        background:linear-gradient(90deg,#ff7400 28.12%,#f91717);
        color: #fff;
        padding: 8px 15px;
        border-radius: 5px;
        text-align: center;
        width: fit-content;
        margin-top: 10px;
        cursor: pointer;
    }
    a.donate-button:hover {
        color: #fff;
    }
</style>
<div class="carousel-cover">
    <div class="carousel-container">
        <div class="carousel-track" id="carouselTrack">
            @php
                $cards = [
                    [
                        'image' => 'https://daankart.com/assets/images/campaign/67c9c79678fdc1741277078.jpeg',
                        'badge' => 'Featured',
                        'title' => 'Help Dev And Chandni Feed Warm Meals To 3000+ Slum Kids This Season Of Giving',
                        'description' => "This holy season, thousands of children in India's slums are fasting with empty stomachs and hopeful hearts..."
                    ],
                    [
                        'image' => 'https://daankart.com/assets/images/campaign/67c929475291c1741236551.jpg',
                        'badge' => 'Urgent',
                        'title' => 'Provide Clean Water To Remote Villages In Africa',
                        'description' => 'Your contribution helps build wells to provide clean drinking water to families...'
                    ],
                    [
                        'image' => 'https://daankart.com/assets/images/campaign/67c918cdda4da1741232333.jpg',
                        'badge' => 'Education',
                        'title' => 'Help Children In Rural India Get Access To Education',
                        'description' => 'Your donation will fund school supplies and books for children in need...'
                    ]
                ];
            @endphp
    
            @foreach ($cards as $card)
            <div class="card">
                <img class="card-image" src="{{ $card['image'] }}" alt="{{ $card['title'] }}">
                <div class="card-content">
                    <div class="badge">{{ $card['badge'] }}</div>
                    <div class="title">{{ $card['title'] }}</div>
                    <div class="description">{{ $card['description'] }}</div>
                    <a href="/donate" class="donate-button">Donate Now</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
<script>
    const track = document.getElementById('carouselTrack');
    let index = 0;

    function slideNext() {
        index = (index + 1) % track.children.length;
        track.style.transform = `translateX(-${index * 800}px)`;
    }

    setInterval(slideNext, 3000);
</script>
