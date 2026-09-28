@extends('layouts.app')

@section('content')
<div class="relative min-h-screen overflow-hidden">
    <!-- Background Video -->
    <video 
        autoplay 
        muted 
        loop 
        class="absolute inset-0 w-full h-full object-cover z-0"
        poster="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1920 1080'%3E%3Cdefs%3E%3ClinearGradient id='grad' x1='0%25' y1='0%25' x2='100%25' y2='100%25'%3E%3Cstop offset='0%25' style='stop-color:%234f46e5;stop-opacity:1' /%3E%3Cstop offset='100%25' style='stop-color:%237c3aed;stop-opacity:1' /%3E%3C/linearGradient%3E%3C/defs%3E%3Crect width='1920' height='1080' fill='url(%23grad)' /%3E%3C/svg%3E">
        
        <!-- Video sources - ganti dengan URL video yang Anda inginkan -->
        <source src="https://res.cloudinary.com/drzzs3aze/video/upload/v1755737821/pedicle_wr6mvd.mp4" type="video/mp4">
        <source src="https://sample-videos.com/zip/10/mp4/SampleVideo_1280x720_1mb.mp4" type="video/mp4">
        
        <!-- Fallback untuk browser yang tidak support video -->
        Your browser does not support the video tag.
    </video>
    
    <!-- Dark Overlay for better text readability -->
    <div class="absolute inset-0 bg-black bg-opacity-40 z-10"></div>
    
    <!-- Main Content -->
    <div class="relative z-20 flex items-center justify-center min-h-screen">
        <div class="text-center">
            <!-- Main Title -->
            <h1 class="text-8xl md:text-9xl font-bold text-white tracking-widest drop-shadow-2xl animate-pulse">
                HALAMAN MASIH PROGRES
            </h1>
            
            <!-- Subtitle (optional) -->
            <p class="text-xl md:text-2xl text-white/80 mt-6 font-light tracking-wide">
                Memantau Kemajuan 
            </p>
            
            <!-- Decorative Element -->
            <div class="mt-8 flex justify-center">
                <div class="w-24 h-1 bg-white/60 rounded-full"></div>
            </div>
        </div>
    </div>
    
    <!-- Optional: Loading animation while video loads -->
    <div id="videoLoader" class="absolute inset-0 bg-gradient-to-br from-indigo-600 to-purple-700 z-5 flex items-center justify-center">
        <div class="text-center">
            <div class="animate-spin rounded-full h-16 w-16 border-4 border-white border-t-transparent mx-auto mb-4"></div>
            <p class="text-white text-lg">Loading...</p>
        </div>
    </div>
</div>

<style>
/* Custom animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fadeInUp {
    animation: fadeInUp 1s ease-out;
}

/* Text shadow for better readability */
h1 {
    text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.8);
}

/* Ensure video covers the entire screen */
video {
    min-width: 100%;
    min-height: 100%;
}

/* Hide scrollbar */
body {
    overflow-x: hidden;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const video = document.querySelector('video');
    const loader = document.getElementById('videoLoader');
    const mainContent = document.querySelector('.relative.z-20');
    
    // Hide loader when video can play
    video.addEventListener('canplay', function() {
        loader.style.opacity = '0';
        setTimeout(() => {
            loader.style.display = 'none';
            mainContent.classList.add('animate-fadeInUp');
        }, 500);
    });
    
    // Fallback: hide loader after 3 seconds if video doesn't load
    setTimeout(() => {
        if (loader.style.display !== 'none') {
            loader.style.opacity = '0';
            setTimeout(() => {
                loader.style.display = 'none';
                mainContent.classList.add('animate-fadeInUp');
            }, 500);
        }
    }, 3000);
    
    // Handle video error
    video.addEventListener('error', function() {
        console.log('Video failed to load, using gradient background');
        loader.style.display = 'none';
        mainContent.classList.add('animate-fadeInUp');
    });
    
    // Ensure video plays (some browsers block autoplay)
    video.play().catch(function(error) {
        console.log('Autoplay prevented:', error);
    });
});
</script>
@endsection