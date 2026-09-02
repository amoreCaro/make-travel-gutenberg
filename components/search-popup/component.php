<?php

if (!defined('ABSPATH')) {
    exit;
}

$locations = get_terms([
    'taxonomy'   => 'locations',
    'hide_empty' => true,
    'number'     => 10,
]);

$item_base = 'search-popup__item group w-full flex items-center gap-3 px-4 sm:px-5 py-3 text-left text-inherit no-underline transition-colors hover:bg-zinc-900/[0.04] dark:hover:bg-white/[0.06] aria-selected:bg-zinc-900/[0.04] dark:aria-selected:bg-white/[0.06]';
$icon_location = 'search-popup__item-icon flex items-center justify-center w-9 h-9 rounded-xl bg-zinc-100 text-zinc-500 dark:bg-white/5 dark:text-zinc-400 transition-colors group-aria-selected:bg-blue-500/10 group-aria-selected:text-blue-500';
?>

<div
    id="searchPopup"
    class="search-popup group/popup fixed inset-0 z-[1100] flex items-start justify-center px-4 pt-[12vh] sm:pt-[16vh] opacity-0 pointer-events-none transition-opacity duration-[220ms] ease-[cubic-bezier(0.22,1,0.36,1)] data-[open=true]:opacity-100 data-[open=true]:pointer-events-auto"
    role="dialog"
    aria-modal="true"
    aria-label="<?php esc_attr_e('Search', THEME); ?>"
    data-open="false"
    hidden
>
    <div
        id="searchPopupOverlay"
        class="search-popup__overlay absolute inset-0 bg-zinc-900/40 dark:bg-black/60 backdrop-blur-sm opacity-0 transition-opacity duration-[220ms] ease-[cubic-bezier(0.22,1,0.36,1)] group-data-[open=true]/popup:opacity-100"
        aria-hidden="true"
    ></div>

    <div class="search-popup__panel relative z-10 w-full max-w-xl overflow-hidden rounded-2xl bg-white dark:bg-[#18171A] border border-black/5 dark:border-white/10 shadow-[0_30px_80px_-20px_rgba(0,0,0,0.35)] opacity-0 translate-y-3 scale-[0.98] transition-[opacity,transform] duration-[280ms] ease-[cubic-bezier(0.22,1,0.36,1)] group-data-[open=true]/popup:opacity-100 group-data-[open=true]/popup:translate-y-0 group-data-[open=true]/popup:scale-100">
        <form
            class="search-popup__form"
            method="get"
            action="<?php echo esc_url(home_url('/')); ?>"
            role="search"
        >
            <div class="search-popup__field relative flex items-center gap-3 px-4 sm:px-5 border-b border-black/5 dark:border-white/10">
                <svg
                    class="search-popup__icon shrink-0 h-5 w-5 text-zinc-400"
                    viewBox="0 0 24 24"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                    aria-hidden="true"
                >
                    <path d="M11.5 21C16.7467 21 21 16.7467 21 11.5C21 6.25329 16.7467 2 11.5 2C6.25329 2 2 6.25329 2 11.5C2 16.7467 6.25329 21 11.5 21Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M22 22L20 20" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>

                <input
                    id="searchPopupInput"
                    type="search"
                    name="s"
                    value=""
                    placeholder="<?php esc_attr_e('Search destinations, cities, stories...', THEME); ?>"
                    autocomplete="off"
                    spellcheck="false"
                    class="search-popup__input flex-1 min-w-0 py-4 sm:py-5 bg-transparent text-black dark:text-white placeholder:text-zinc-400 dark:placeholder:text-zinc-500 text-base sm:text-[17px] focus:outline-none appearance-none [&::-webkit-search-decoration]:appearance-none [&::-webkit-search-cancel-button]:appearance-none [&::-webkit-search-results-button]:appearance-none [&::-webkit-search-results-decoration]:appearance-none"
                    aria-controls="searchPopupResults"
                    aria-autocomplete="list"
                >

                <button
                    type="button"
                    id="clearSearchPopup"
                    class="search-popup__clear hidden shrink-0 text-xs font-medium text-zinc-400 hover:text-zinc-700 dark:hover:text-zinc-200 transition-colors"
                >
                    <?php _e('Clear', THEME); ?>
                </button>

                <button
                    type="button"
                    id="closeSearchPopup"
                    class="shrink-0 inline-flex items-center justify-center w-8 h-8 rounded-lg text-zinc-400 hover:text-zinc-700 hover:bg-zinc-100 dark:hover:text-white dark:hover:bg-white/10 transition-colors"
                    aria-label="<?php esc_attr_e('Close search', THEME); ?>"
                >
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </form>

        <div
            id="searchPopupResults"
            class="search-popup__results max-h-[50vh] overflow-y-auto overscroll-contain py-2 [scrollbar-width:thin] [scrollbar-color:rgba(113,113,122,0.45)_transparent]"
            role="listbox"
        >
            <button
                type="button"
                class="<?php echo esc_attr($item_base); ?> search-popup__item--query !hidden"
                data-search-action="query"
                role="option"
                aria-selected="false"
            >
                <span class="search-popup__item-icon flex items-center justify-center w-9 h-9 rounded-xl bg-blue-500/10 text-blue-500">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M11.5 21C16.7467 21 21 16.7467 21 11.5C21 6.25329 16.7467 2 11.5 2C6.25329 2 2 6.25329 2 11.5C2 16.7467 6.25329 21 11.5 21Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M22 22L20 20" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
                <span class="min-w-0 flex-1">
                    <span class="block text-sm text-zinc-500 dark:text-zinc-400"><?php _e('Search for', THEME); ?></span>
                    <span class="search-popup__query-text block text-[15px] font-medium text-black dark:text-white truncate"></span>
                </span>
                <span class="hidden sm:inline text-[11px] text-zinc-400 border border-black/10 dark:border-white/10 rounded-md px-1.5 py-0.5">↵</span>
            </button>

            <?php if (!empty($locations) && !is_wp_error($locations)) : ?>
                <p class="search-popup__section px-4 sm:px-5 pt-2 pb-1 text-[11px] font-medium uppercase tracking-[0.14em] text-zinc-400 dark:text-zinc-500">
                    <?php _e('Locations', THEME); ?>
                </p>

                <?php foreach ($locations as $term) : ?>
                    <a
                        href="<?php echo esc_url(get_term_link($term)); ?>"
                        class="<?php echo esc_attr($item_base); ?>"
                        data-search-action="location"
                        data-label="<?php echo esc_attr(strtolower($term->name)); ?>"
                        role="option"
                        aria-selected="false"
                    >
                        <span class="<?php echo esc_attr($icon_location); ?>">
                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                            </svg>
                        </span>
                        <span class="min-w-0 flex-1">
                            <span class="block text-[15px] font-medium text-black dark:text-white truncate">
                                <?php echo esc_html($term->name); ?>
                            </span>
                            <span class="block text-xs text-zinc-400 dark:text-zinc-500">
                                <?php
                                printf(
                                    /* translators: %d: posts count */
                                    _n('%d story', '%d stories', (int) $term->count, THEME),
                                    (int) $term->count
                                );
                                ?>
                            </span>
                        </span>
                    </a>
                <?php endforeach; ?>
            <?php endif; ?>

            <p class="search-popup__empty hidden px-4 sm:px-5 py-8 text-center text-sm text-zinc-400 dark:text-zinc-500">
                <?php _e('No matching locations. Press Enter to search.', THEME); ?>
            </p>
        </div>
    </div>
</div>
