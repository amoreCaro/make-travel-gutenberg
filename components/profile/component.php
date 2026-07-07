<?php
if (!defined('ABSPATH')) {
    exit;
}

// Consolidate variable scope cleanly
$display_name     = $args['username'] ?? $current_user->display_name ?? 'User';
$user_email       = $args['user_email'] ?? $current_user->user_email ?? '';
$user_description = $args['description'] ?? $current_user->description ?? 'Immerse yourself in the world of literature with our curated collection of books. From bestsellers to hidden gems, our assortment caters to a variety of interests'; // Added description fallback
$initial          = !empty($display_name) ? esc_html(strtoupper(substr($display_name, 0, 1))) : '?';

$youtube = $args['youtube'] ?? $youtube ?? '#';
$tiktok  = $args['tiktok'] ?? $tiktok ?? '#';
$github  = $args['github'] ?? $github ?? '#';
?>

<div class="rounded-3xl border border-zinc-200 bg-zinc-50/50 p-6 sm:p-8 dark:border-zinc-800/80 dark:bg-[#18181B]">
    
    <div class="flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between">
        
        <!-- Identity Block -->
        <div class="flex items-center gap-4 min-w-0 flex-1">
            <!-- Sleek Initials Avatar -->
            <div class="flex h-14 w-14 shrink-0 select-none items-center justify-center rounded-full bg-zinc-900 font-medium text-zinc-100 text-lg dark:bg-zinc-100 dark:text-zinc-900">
                <?php echo $initial; ?>
            </div>
            
            <!-- Information -->
            <div class="min-w-0 flex-1">
                <h3 class="truncate font-medium text-zinc-950 text-base dark:text-zinc-50">
                    <?php echo esc_html($display_name); ?>
                </h3>
                <?php if (!empty($user_email)) : ?>
                    <p class="truncate text-sm text-zinc-500 dark:text-zinc-400">
                        <?php echo esc_html($user_email); ?>
                    </p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Social Connections -->
        <div class="flex items-center gap-1.5 self-start sm:self-center shrink-0">
            <!-- YouTube -->
            <a href="<?php echo esc_url($youtube); ?>" 
               class="inline-flex h-9 w-9 items-center justify-center rounded-lg text-zinc-400 transition-colors hover:bg-zinc-100 hover:text-zinc-900 dark:text-zinc-500 dark:hover:bg-zinc-800/60 dark:hover:text-zinc-100" 
               aria-label="YouTube" <?php echo $youtube !== '#' ? 'target="_blank" rel="noopener"' : ''; ?>>
                <svg fill="currentColor" class="h-4 w-4" viewBox="0 0 576 512"><path d="M549.655 124.083c-6.281-23.65-24.787-42.276-48.284-48.597C458.781 64 288 64 288 64S117.22 64 74.629 75.486c-23.497 6.322-42.003 24.947-48.284 48.597-11.412 42.867-11.412 132.305-11.412 132.305s0 89.438 11.412 132.305c6.281 23.65 24.787 41.5 48.284 47.821C117.22 448 288 448 288 448s170.78 0 213.371-11.486c23.497-6.321 42.003-24.171 48.284-47.821 11.412-42.867 11.412-132.305 11.412-132.305s0-89.438-11.412-132.305zm-317.51 213.508V175.185l142.739 81.205-142.739 81.201z"></path></svg>
            </a>
            
            <!-- TikTok -->
            <a href="<?php echo esc_url($tiktok); ?>" 
               class="inline-flex h-9 w-9 items-center justify-center rounded-lg text-zinc-400 transition-colors hover:bg-zinc-100 hover:text-zinc-900 dark:text-zinc-500 dark:hover:bg-zinc-800/60 dark:hover:text-zinc-100" 
               aria-label="TikTok" <?php echo $tiktok !== '#' ? 'target="_blank" rel="noopener"' : ''; ?>>
                <svg fill="currentColor" class="h-4 w-4" viewBox="0 0 448 512"><path d="M448,209.91a210.06,210.06,0,0,1-122.77-39.25V349.38A162.55,162.55,0,1,1,185,188.31V278.2a74.62,74.62,0,1,0,52.23,71.18V0l88,0a121.18,121.18,0,0,0,1.86,22.17h0A122.18,122.18,0,0,0,381,102.39a121.43,121.43,0,0,0,67,20.14Z"></path></svg>
            </a>
            
            <!-- GitHub -->
            <a href="<?php echo esc_url($github); ?>" 
               class="inline-flex h-9 w-9 items-center justify-center rounded-lg text-zinc-400 transition-colors hover:bg-zinc-100 hover:text-zinc-900 dark:text-zinc-500 dark:hover:bg-zinc-800/60 dark:hover:text-zinc-100" 
               aria-label="GitHub" <?php echo $github !== '#' ? 'target="_blank" rel="noopener"' : ''; ?>>
                <svg fill="currentColor" class="h-4 w-4" viewBox="0 0 496 512"><path d="M165.9 397.4c0 2-2.3 3.6-5.2 3.6-3.3.3-5.6-1.3-5.6-3.6 0-2 2.3-3.6 5.2-3.6 3-.3 5.6 1.3 5.6 3.6zm-31.1-4.5c-.7 2 1.3 4.3 4.3 4.9 2.6 1 5.6 0 6.2-2s-1.3-4.3-4.3-5.2c-2.6-.7-5.5.3-6.2 2.3zm44.2-1.7c-2.9.7-4.9 2.6-4.6 4.9.3 2 2.9 3.3 5.9 2.6 2.9-.7 4.9-2.6 4.6-4.6-.3-1.9-3-3.2-5.9-2.9zM244.8 8C106.1 8 0 113.3 0 252c0 110.9 69.8 205.8 169.5 239.2 12.8 2.3 17.3-5.6 17.3-12.1 0-6.2-.3-40.4-.3-61.4 0 0-70 15-84.7-29.8 0 0-11.4-29.1-27.8-36.6 0 0-22.9-15.7 1.6-15.4 0 0 24.9 2 38.6 25.8 21.9 38.6 58.6 27.5 72.9 20.9 2.3-16 8.8-27.1 16-33.7-55.9-6.2-112.3-14.3-112.3-110.5 0-27.5 7.6-41.3 23.6-58.9-2.6-6.5-11.1-33.3 2.6-67.9 20.9-6.5 69 27 69 27 20-5.6 41.5-8.5 62.8-8.5s42.8 2.9 62.8 8.5c0 0 48.1-33.6 69-27 13.7 34.7 5.2 61.4 2.6 67.9 16 17.7 25.8 31.5 25.8 58.9 0 96.5-58.9 104.2-114.8 110.5 9.2 7.9 17 22.9 17 46.4 0 33.7-.3 75.4-.3 83.6 0 6.5 4.6 14.4 17.3 12.1C428.2 457.8 496 362.9 496 252 496 113.3 383.5 8 244.8 8zM97.2 352.9c-1.3 1-1 3.3.7 5.2 1.6 1.6 3.9 2.3 5.2 1 1.3-1 1-3.3-.7-5.2-1.6-1.6-3.9-2.3-5.2-1zm-10.8-8.1c-.7 1.3.3 2.9 2.3 3.9 1.6 1 3.6.7 4.3-.7.7-1.3-.3-2.9-2.3-3.9-2-.6-3.6-.3-4.3.7zm32.4 35.6c-1.6 1.3-1 4.3 1.3 6.2 2.3 2.3 5.2 2.6 6.5 1 1.3-1.3.7-4.3-1.3-6.2-2.2-2.3-5.2-2.6-6.5-1zm-11.4-14.7c-1.6 1-1.6 3.6 0 5.9 1.6 2.3 4.3 3.3 5.6 2.3 1.6-1.3 1.6-3.9 0-6.2-1.4-2.3-4-3.3-5.6-2z"></path></svg>
            </a>
        </div>
        
    </div>

    <!-- Profile Description Block -->

        <div class="mt-5 pt-5 border-t border-zinc-200/60 dark:border-zinc-800/60">
            <p class="text-sm leading-relaxed text-zinc-600 dark:text-zinc-400">
            Immerse yourself in the world of literature with our curated collection of books. From bestsellers to hidden gems, our assortment caters to a variety of interests
            </p>
        </div>

</div>