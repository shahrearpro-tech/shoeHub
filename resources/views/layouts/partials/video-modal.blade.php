<!-- Video Lightbox Modal -->
<div id="video-lightbox" class="fixed inset-0 z-[100] hidden items-center justify-center p-4 md:p-10">
    <div class="absolute inset-0 bg-secondary/95 backdrop-blur-xl cursor-crosshair"></div>
    <div id="video-content-wrapper" class="relative z-10 w-full max-w-5xl aspect-video bg-black rounded-[2rem] overflow-hidden shadow-[0_50px_100px_-20px_rgba(0,0,0,0.5)] border border-white/10 opacity-0 transform scale-95 transition-all">
        <button onclick="closeVideoLightbox()" class="absolute top-6 right-6 w-12 h-12 bg-white/10 hover:bg-white/20 text-white rounded-full flex items-center justify-center transition-all z-20 group">
            <i class="fas fa-times group-hover:rotate-90 transition-transform"></i>
        </button>
        <div id="video-container" class="w-full h-full">
            <!-- Iframe injected by JS -->
        </div>
    </div>
</div>
