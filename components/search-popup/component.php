<?php
if (!defined('ABSPATH')) {
    exit;
}
?>

<div
    id="searchPopup"
    class="search-popup group/popup fixed inset-0 z-[1100] flex items-start justify-center px-4 pt-[10vh] opacity-0 pointer-events-none transition-opacity duration-200 ease-out data-[open=true]:opacity-100 data-[open=true]:pointer-events-auto"
    role="dialog"
    aria-modal="true"
    aria-label="<?php esc_attr_e('Search', THEME); ?>"
    data-open="false"
    hidden
>
    <!-- PANEL -->
    <div
        class="search-popup__panel relative z-10 w-full max-w-2xl overflow-hidden rounded-2xl bg-white text-gray-800 border border-gray-200 shadow-2xl opacity-0 translate-y-2 scale-[0.99] transition-all duration-200 group-data-[open=true]/popup:opacity-100 group-data-[open=true]/popup:translate-y-0 group-data-[open=true]/popup:scale-100 dark:bg-[#212833] dark:text-gray-200 dark:border-slate-700/50"
        style="position: fixed; right: 17.5%;"
    >

        <!-- SEARCH FORM -->
        <form
            id="searchPopupForm"
            class="search-popup__form p-4 sm:p-5 pb-3 border-b border-gray-200 dark:border-slate-700/40"
            method="get"
            action="<?php echo esc_url(home_url('/')); ?>"
            role="search"
        >

            <!-- FILTERS -->
            <div class="flex items-center gap-2 mt-4 overflow-x-auto no-scrollbar text-xs font-medium">

                <button
                    type="button"
                    class="search-filter px-3 py-1.5 rounded-full bg-gray-100 text-gray-900 border border-gray-200 dark:bg-[#181D26] dark:text-white dark:border-slate-700/60 whitespace-nowrap"
                    data-filter="all"
                >
                    <?php _e('All results', THEME); ?>

                    <span
                        id="searchTotal"
                        class="text-gray-400 dark:text-slate-400 ml-1"
                    >
                        | 0
                    </span>
                </button>

            </div>

        </form>

        <!-- RESULTS -->
        <div
            id="searchPopupResults"
            class="search-popup__results max-h-[55vh] overflow-y-auto px-4 sm:px-5 py-3 space-y-4 [scrollbar-width:thin] [scrollbar-color:#38bdf8_transparent]"
            role="listbox"
        >

            <!-- INITIAL STATE -->
            <div
                id="searchInitialState"
                class="py-10 text-center"
            >
                <p class="text-sm text-gray-500 dark:text-slate-400">
                    <?php _e('Start typing to search...', THEME); ?>
                </p>
            </div>

            <!-- LOADING -->
            <div
                id="searchLoading"
                class="hidden py-10 text-center"
            >
                <div class="inline-flex items-center gap-3 text-sm text-gray-500 dark:text-slate-400">

                    <svg
                        class="w-5 h-5 animate-spin text-sky-500 dark:text-sky-400"
                        viewBox="0 0 24 24"
                        fill="none"
                    >
                        <circle
                            cx="12"
                            cy="12"
                            r="9"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-opacity=".25"
                        />

                        <path
                            d="M21 12a9 9 0 0 0-9-9"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                        />
                    </svg>

                    <?php _e('Searching...', THEME); ?>

                </div>
            </div>

            <!-- RESULTS CONTENT -->
            <div
                id="searchResultsContent"
                class="hidden"
            ></div>

            <!-- EMPTY -->
            <div
                id="searchEmpty"
                class="hidden py-10 text-center"
            >
                <p class="text-sm text-gray-500 dark:text-slate-400">
                    <?php _e('No matching results found.', THEME); ?>
                </p>
            </div>

        </div>

    </div>
</div>