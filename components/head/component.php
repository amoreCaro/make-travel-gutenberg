<?php
if (!defined('ABSPATH')) {
    exit;
}

$page_title = $args['page_title'] ?? '';
$excerpt    = $args['excerpt'] ?? '';
?>

<div class="container relative mb-8 overflow-hidden rounded-[28px] border border-gray-200/70 bg-white p-10 lg:p-14 dark:border-[#232125] dark:bg-[#18181B]">

    <div
        class="pointer-events-none absolute -top-24 -right-24 h-72 w-72 rounded-full bg-violet-500/10 blur-3xl dark:bg-violet-500/20">
    </div>

    <div
        class="pointer-events-none absolute -bottom-20 -left-20 h-64 w-64 rounded-full bg-fuchsia-500/10 blur-3xl dark:bg-fuchsia-500/15">
    </div>

    <div class="relative z-10">

        <?php if (!empty($page_title)) : ?>
            <h1 class="mt-6 text-4xl font-bold tracking-tight text-slate-900 dark:text-white lg:text-5xl">
                <?php echo esc_html($page_title); ?>
            </h1>
        <?php endif; ?>

        <?php if (!empty($excerpt)) : ?>
            <p class="mt-4 max-w-2xl text-lg leading-8 text-slate-600 dark:text-slate-400">
                <?php echo esc_html($excerpt); ?>
            </p>
        <?php endif; ?>

    </div>

</div>