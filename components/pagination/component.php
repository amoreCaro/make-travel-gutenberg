<?php
if (!defined('ABSPATH')) exit;

global $wp_query;

$paged = max(1, get_query_var('paged'), get_query_var('page'));
$total_pages = $wp_query->max_num_pages;

if ($total_pages > 1) :

    $links = paginate_links([
        'current'   => $paged,
        'total'     => $total_pages,
        'prev_text' => '←',
        'next_text' => '→',
        'type'      => 'array',
        'mid_size'  => 3,  
        'end_size'  => 0,  
    ]);

if (is_array($links)) {
    $filtered_links = [];

    foreach ($links as $link) {
        // Прибираємо "dots"
        if (strpos($link, 'dots') !== false) continue;

        // Отримуємо число з лінку
        $num = (int) strip_tags($link);

        // Прибираємо першу сторінку, якщо вона не в межах mid_size
        if ($num === 1 && $paged - 3 > 1) continue;
        if ($num === $total_pages && $paged + 3 < $total_pages) continue;

        $filtered_links[] = $link;
    }

    $links = $filtered_links;
}
?>
<div class="pagination flex items-center justify-center py-6">
    <ul class="flex items-center gap-2">
        <?php foreach ($links as $link) : 
            $is_current = strpos($link, 'current') !== false;

            if ($is_current) {
                $link = str_replace(
                    'current',
                    'current flex items-center justify-center w-12 h-12 
                    border-2 border-blue-600 text-blue-600 font-semibold rounded-lg
                    dark:border-white dark:text-white',
                    $link
                );
            } else {
                $link = str_replace(
                    'page-numbers',
                    'page-numbers flex items-center justify-center w-12 h-12 
                    border border-gray-300 text-gray-500 rounded-lg transition-all duration-200
                    hover:border-blue-600 hover:text-blue-600
                    dark:border-white/30 dark:text-white/70 
                    dark:hover:border-white dark:hover:text-white',
                    $link
                );
            }
        ?>
            <li><?php echo $link; ?></li>
        <?php endforeach; ?>
    </ul>
</div><?php
endif;
?>