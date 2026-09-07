<?php
if (!defined('ABSPATH')) {
    exit;
}
?>

<style>
    .search-popup--transparent .search-popup__panel {
        background-color: transparent !important;
        -webkit-backdrop-filter: blur(20px) saturate(150%);
        backdrop-filter: blur(20px) saturate(150%);
    }

    /* Десктоп: попап прив'язаний до #searchWrapper (position: relative у ньому) */
    .search-popup {
        position: absolute !important;
        top: calc(100% + 12px) !important;
        right: 0 !important;
        left: auto !important;
        width: max-content !important;
        min-width: 24rem !important;
        max-width: 32rem !important;
        z-index: 999999 !important;
    }

    /* Мобільні пристрої: розтягується майже на весь екран */
    @media (max-width: 639px) {
        .search-popup {
            position: fixed !important;
            top: 4.5rem !important;
            left: 1rem !important;
            right: 1rem !important;
            width: auto !important;
            min-width: 0 !important;
            max-width: none !important;
        }
    }
</style>

<div
    id="searchResultsPopup"
    class="search-popup group/popup opacity-0 pointer-events-none transition-opacity duration-200 ease-out data-[open=true]:opacity-100 data-[open=true]:pointer-events-auto"
    role="dialog"
    aria-modal="true"
    data-open="false"
    hidden
>
    <div
        id="searchPopupOverlay"
        class="search-popup__overlay fixed inset-0 bg-transparent -z-10 sm:hidden"
        aria-hidden="true"
    ></div>

    <div
        class="search-popup__panel relative w-full overflow-hidden rounded-2xl bg-white text-zinc-900 border border-zinc-200/80 shadow-2xl transition-all duration-200 translate-y-2 group-data-[open=true]/popup:translate-y-0 dark:bg-[#18181b] dark:text-zinc-100 dark:border-zinc-700/40"
    >
        <div
            id="searchPopupResults"
            class="search-popup__results p-5 text-sm"
        >

            <div
                id="searchLoader"
                class="hidden text-center py-6 text-zinc-500 dark:text-zinc-400 font-medium"
            >
                <span class="inline-block animate-pulse">
                    <?php _e('Searching...', THEME); ?>
                </span>
            </div>

            <div
                id="searchSummary"
                class="hidden flex justify-between items-center space-y-0 pb-3 mb-3 border-b border-zinc-100 dark:border-zinc-800"
            >
                <div
                    id="searchCounts"
                    class="space-y-1 text-xs font-semibold text-zinc-500 dark:text-zinc-400"
                >
                </div>

                <a
                    id="searchViewAllBtn"
                    href="#"
                    style="margin: 0;"
                    class="m-0 pt-0 inline-block text-xs font-bold uppercase tracking-wider text-blue-600 hover:text-blue-700 dark:text-blue-500 dark:hover:text-blue-400 underline underline-offset-4 transition-colors"
                >
                    <?php _e('SEE ALL 0 RESULTS', THEME); ?>
                </a>
            </div>

            <div
                id="searchResultsList"
                class="search-popup__list space-y-3 max-h-[335px] overflow-y-auto pr-2 custom-scrollbar text-zinc-800 dark:text-zinc-200 [&_a]:text-zinc-800 [&_a:hover]:text-blue-600 dark:[&_a]:text-zinc-200 dark:[&_a:hover]:text-blue-400"
            >
            </div>

            <div
                id="searchEmpty"
                class="hidden text-center py-6 text-zinc-500 dark:text-zinc-400"
            >
                <?php _e('No results found.', THEME); ?>
            </div>

        </div>

    </div>
</div>