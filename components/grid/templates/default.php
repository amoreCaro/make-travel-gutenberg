<?php

if (!defined('ABSPATH')) {
    exit;
}

$photos        = $photos ?? [];
$columns       = (int) ($columns ?? 2);
$mobile_cols   = (int) ($mobile_cols ?? 1);
$tablet_cols   = (int) ($tablet_cols ?? 2);
$block_classes = $block_classes ?? ['photo-grid'];
$fancy_group   = $fancy_group ?? 'photo-grid';
$base_path     = $base_path ?? PATH . '/components/grid/';

if (empty($photos)) {
    return;
}
?>

<div
    class="<?php echo esc_attr(implode(' ', $block_classes)); ?>"
    style="<?php echo esc_attr(
        '--photo-grid-cols:' . $columns . ';'
        . '--photo-grid-cols-mobile:' . $mobile_cols . ';'
        . '--photo-grid-cols-tablet:' . $tablet_cols . ';'
    ); ?>"
>
    <?php foreach ($photos as $index => $photo) : ?>
        <?php include $base_path . 'elements/item.php'; ?>
    <?php endforeach; ?>
</div>
