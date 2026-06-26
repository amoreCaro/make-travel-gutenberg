<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>

<main class="site-main w-full min-h-[85vh] bg-neutral-50 dark:bg-neutral-950 px-6 py-16 flex items-center justify-center transition-colors duration-300">
    <!-- Single Column Layout Container -->
    <div class="w-full max-w-2xl mx-auto flex flex-col items-center text-center">
        
        <!-- Premium Ambient Pulse / Typography Combo -->
        <div class="relative flex items-center justify-center select-none w-full mb-6">
            <!-- Large ambient glow pulse behind the text -->
            <div class="absolute inset-0 bg-neutral-200/50  rounded-full blur-3xl opacity-70 animate-pulse scale-75"></div>
            
            <h1 class="relative font-sans text-[48vw] sm:text-[280px] md:text-[340px] font-black leading-none tracking-tighter text-neutral-900 dark:text-white opacity-95">
                404
            </h1>
        </div>

        <!-- Clean, focused copy -->
        <p class="max-w-md font-sans text-sm md:text-base text-neutral-500 dark:text-neutral-400 font-medium leading-relaxed mb-10">
            <?php esc_html_e( 'The page you are looking for doesn\'t exist - or it has been intentionally removed.', 'make-travel' ); ?>
        </p>

        <!-- Go Back Button with Animated Hover Arrow -->
        <a href="javascript:history.back()"
           class="group inline-flex items-center justify-center gap-2.5 rounded-xl bg-neutral-950 dark:bg-white px-8 py-4 font-sans text-xs font-bold uppercase tracking-wider text-white dark:text-neutral-950 transition-all duration-200 hover:bg-neutral-800 dark:hover:bg-neutral-100 shadow-md">
            
            <!-- Arrow moves smoothly to the left on hover -->
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" 
                 class="w-4 h-4 transform transition-transform duration-200 ease-out group-hover:-translate-x-1">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
            </svg>
            
            <?php esc_html_e( 'Go Back', 'make-travel' ); ?>
        </a>

    </div>
</main>

<?php get_footer(); ?>