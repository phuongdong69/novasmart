@php
    $slideshows = \App\Models\Slideshow::active()->ordered()->take(3)->get();
@endphp

<!-- Slideshow CSS - Standalone -->
<link rel="stylesheet" href="{{ asset('assets/css/slideshow-standalone.css') }}">

<div class="slideshow-standalone" style="margin-top: 35px;">
    @forelse($slideshows as $index => $slideshow)
        <div class="slide fade {{ $index === 0 ? 'active' : '' }}">
            <img src="{{ asset('storage/' . $slideshow->image) }}" alt="{{ $slideshow->title }}">
            @if ($slideshow->title || $slideshow->description)
                <div class="slide-content">
                    @if ($slideshow->title)
                        <h2>{{ $slideshow->title }}</h2>
                    @endif
                    @if ($slideshow->description)
                        <p>{{ $slideshow->description }}</p>
                    @endif
                    @if ($slideshow->link)
                        <a href="{{ $slideshow->link }}">
                            Xem thêm
                        </a>
                    @endif
                </div>
            @endif
        </div>
    @empty
        <div class="slide fade active">
            <img src="{{ asset('assets/images/default-slide.jpg') }}" alt="Default slide">
        </div>
    @endforelse

    <!-- Navigation dots -->
    <div class="dots-container">
        @foreach ($slideshows as $index => $slideshow)
            <span class="dot {{ $index === 0 ? 'active' : '' }}" onclick="currentSlide({{ $index + 1 }})"></span>
        @endforeach
    </div>

    <!-- Navigation arrows -->
    <a class="prev" onclick="changeSlide(-1)">❮</a>
    <a class="next" onclick="changeSlide(1)">❯</a>
</div>

<!-- Slideshow JavaScript -->
<script>
    let slideIndex = 1;
    let slideInterval;

    function showSlides(n) {
        let i;
        let slides = document.getElementsByClassName("slide");
        let dots = document.getElementsByClassName("dot");

        if (n > slides.length) {
            slideIndex = 1
        }
        if (n < 1) {
            slideIndex = slides.length
        }

        for (i = 0; i < slides.length; i++) {
            slides[i].classList.remove("active");
        }
        for (i = 0; i < dots.length; i++) {
            dots[i].classList.remove("active");
        }

        slides[slideIndex - 1].classList.add("active");
        if (dots[slideIndex - 1]) {
            dots[slideIndex - 1].classList.add("active");
        }
    }

    function changeSlide(n) {
        showSlides(slideIndex += n);
        resetInterval();
    }

    function currentSlide(n) {
        showSlides(slideIndex = n);
        resetInterval();
    }

    function resetInterval() {
        clearInterval(slideInterval);
        slideInterval = setInterval(function() {
            changeSlide(1);
        }, 2000);
    }

    // Auto slide every 2 seconds
    document.addEventListener('DOMContentLoaded', function() {
        slideInterval = setInterval(function() {
            changeSlide(1);
        }, 2000);
    });
</script>
