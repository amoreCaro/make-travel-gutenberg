<?php
if (!defined('ABSPATH')) {
    exit;
}
?>

<div id="video-modal" 
    class="group fixed inset-0 z-[100] flex items-center justify-center bg-black/90 backdrop-blur-sm px-4 
            opacity-0 pointer-events-none transition-all duration-300 
            [&.isOpen]:opacity-100 [&.isOpen]:pointer-events-auto">
    
    <div id="modal-container" 
        class="relative w-full max-w-4xl transition-transform duration-300 ease-out 
                scale-95 group-[.isOpen]:scale-100">
        
        <button id="modal-close" class="absolute -top-10 right-0 md:-top-12 md:-right-0 text-white/70 hover:text-white transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <div class="overflow-hidden bg-black shadow-2xl">
            <video id="modal-video" class="w-full aspect-video block" controls>
                <source src="" type="video/mp4">
                Ваш браузер не підтримує відео.
            </video>
        </div>
    </div>
</div>  