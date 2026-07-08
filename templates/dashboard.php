<?php
/**
 * Template Name: Dashboard Template
 */

if (!defined('ABSPATH')) {
    exit;
}

$paged = max(
    1,
    get_query_var('paged'),
    get_query_var('page')
);

$dashboard_posts = new WP_Query([
    'post_type'      => 'post',
    'author'         => get_current_user_id(),
    'post_status'    => 'publish',
    'posts_per_page' => 6,
    'paged'          => $paged,
    'orderby'        => 'date',
    'order'          => 'DESC',
]);

$temp_query = $wp_query;
$wp_query   = $dashboard_posts;

$current_user = wp_get_current_user();
$display_name = !empty($current_user->display_name) ? $current_user->display_name : __('User', THEME);
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class('bg-slate-50 dark:bg-[#09090b] antialiased text-slate-900 dark:text-slate-50'); ?>>

<div class="flex min-h-screen w-full overflow-x-hidden">

    <!-- Sidebar -->
    <aside class="hidden lg:block w-[280px] min-h-screen fixed top-0 bg-white dark:bg-[#121214] border-r border-slate-200/80 dark:border-zinc-800/80 overflow-y-auto z-20 shrink-0">
        <?php get_template_part('components/account-sidebar/component'); ?>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 px-4 sm:px-6 lg:px-10 max-w-7xl mx-auto w-full overflow-hidden mt-10">
        
        <!-- Mobile Header (Optional suggestion for usability) -->
        <div class="flex lg:hidden items-center justify-between  pb-4 border-b border-slate-200/60 dark:border-zinc-800">
            <span class="font-bold text-lg">Dashboard</span>
            <button class="p-2 text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-zinc-800 rounded-xl" aria-label="Open menu">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>

        <!-- Welcome Banner -->
        <div class="relative mb-8 overflow-hidden rounded-3xl border border-slate-200/70 bg-gradient-to-br from-white to-slate-50/50 p-8 sm:p-10 lg:p-12 dark:border-zinc-800 dark:bg-gradient-to-br dark:from-[#121214] dark:to-[#161619]">
            <div class="pointer-events-none absolute -top-24 -right-24 h-72 w-72 rounded-full bg-indigo-500/10 blur-3xl dark:bg-indigo-500/15"></div>
            <div class="pointer-events-none absolute -bottom-20 -left-20 h-64 w-64 rounded-full bg-purple-500/10 blur-3xl dark:bg-purple-500/10"></div>

            <div class="relative z-10 max-w-3xl">
                <h1 class="text-3xl font-extrabold tracking-tight text-slate-900 dark:text-white sm:text-4xl lg:text-5xl">
                    <?php printf(__('Hello, %s!', THEME), esc_html($display_name)); ?>
                </h1>
                <p class="mt-3 text-base sm:text-lg leading-relaxed text-slate-500 dark:text-slate-400">
                    <?php _e('Write your thoughts, upload media, organize categories, and publish beautiful content.', THEME); ?>                   
                </p>
            </div>
        </div>

        <!-- Toolbar & Filter Area -->
        <div class="w-full">
            <section class="w-full">
                <div class="bg-white dark:bg-[#121214] rounded-2xl border border-slate-200/80 dark:border-zinc-800 p-4 sm:p-6 shadow-sm shadow-slate-100/50 dark:shadow-none">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        
                        <!-- Search -->
                        <div class="relative w-full sm:max-w-md">
                            <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400 dark:text-zinc-500" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <circle cx="11" cy="11" r="8"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35"/>
                            </svg>
                            <input type="text" placeholder="<?php esc_attr_e('Search posts...', THEME); ?>" class="w-full h-11 pl-11 pr-4 rounded-xl border border-slate-200 dark:border-zinc-700 bg-slate-50/50 dark:bg-zinc-900 focus:bg-white dark:focus:bg-zinc-900 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm transition-all">
                        </div>

                        <!-- Grid/List Switcher -->
                        <div class="inline-flex items-center gap-1 p-1 bg-slate-100 dark:bg-zinc-900/60 border border-slate-200/60 dark:border-zinc-800/80 rounded-xl self-end sm:self-auto">
                            <button class="view-btn active group h-8 px-3 rounded-lg flex items-center justify-center text-slate-500 dark:text-zinc-400 hover:text-slate-800 dark:hover:text-zinc-200 transition-all duration-200 [&.active]:bg-white dark:[&.active]:bg-zinc-800 [&.active]:text-slate-900 dark:[&.active]:text-slate-50 [&.active]:shadow-sm text-sm font-medium gap-1.5" data-view="grid" aria-label="Grid view">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                                </svg>
                            </button>
                            <button class="view-btn group h-8 px-3 rounded-lg flex items-center justify-center text-slate-500 dark:text-zinc-400 hover:text-slate-800 dark:hover:text-zinc-200 transition-all duration-200 [&.active]:bg-white dark:[&.active]:bg-zinc-800 [&.active]:text-slate-900 dark:[&.active]:text-slate-50 [&.active]:shadow-sm text-sm font-medium gap-1.5" data-view="list" aria-label="List view">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                                </svg>
                            </button>
                        </div>

                    </div>
                </div>

                <!-- Posts Grid/List Container -->
                <!-- Класи за замовчуванням налаштовані на Grid (md:grid-cols-2 lg:grid-cols-3). Якщо активовано List, JS-скрипт має перемикати класи на grid-cols-1 -->
                <div id="posts-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6 transition-all duration-3xl">
                    <?php if ($dashboard_posts->have_posts()) : ?>
                        <?php while ($dashboard_posts->have_posts()) : $dashboard_posts->the_post(); ?>
                            <?php
                            $categories  = get_the_category(get_the_ID());
                            $category_id = !empty($categories) ? $categories[0]->term_id : null;

                            if ($category_id) {
                                $icon_id  = carbon_get_term_meta($category_id, 'category_svg');
                                $icon_url = $icon_id ? wp_get_attachment_url($icon_id) : '';

                                $category_data = [
                                    'id'         => $category_id,
                                    'name'       => $categories[0]->name,
                                    'link'       => get_category_link($category_id),
                                    'svg'        => cf_get_inline_svg($icon_url),
                                    'bg_color'   => carbon_get_term_meta($category_id, 'category_bg'),
                                    'text_color' => carbon_get_term_meta($category_id, 'category_text_color'),
                                    'decor_type' => carbon_get_term_meta($category_id, 'category_decor_type'),
                                ];

                                // Зверніть увагу: якщо ви використовуєте "horizontal-item.php", він заточений під список.
                                // Бажано мати також bento/elements/grid-item.php і підключати його залежно від обраного виду.
                                include PATH . '/components/bento/elements/horizontal-item.php';
                            }
                            ?>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </div>

                <!-- Pagination Container -->
                <div class="mt-8 pt-6 border-t border-slate-200/60 dark:border-zinc-800">
                    <?php require PATH . '/components/pagination/component.php'; ?>
                </div>
                
                <?php
                wp_reset_postdata();
                $wp_query = $temp_query;
                ?>
            </section>
        </div>

    </main>
</div>

<?php wp_footer(); ?>

<!-- Простий скрипт для демонстрації перемикання Grid/List -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const buttons = document.querySelectorAll('.view-btn');
    const container = document.getElementById('posts-container');
    
    buttons.forEach(btn => {
        btn.addEventListener('click', function() {
            buttons.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            const view = this.getAttribute('data-view');
            if(view === 'list') {
                container.classList.remove('md:grid-cols-2', 'lg:grid-cols-3');
                container.classList.add('grid-cols-1');
            } else {
                container.classList.add('md:grid-cols-2', 'lg:grid-cols-3');
                container.classList.remove('grid-cols-1');
            }
        });
    });
});
</script>
</body>
</html>