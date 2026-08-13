<?php
if (!defined('ABSPATH')) {
    exit;
}

$page_title   = get_the_title();
$page_excerpt = has_excerpt() ? get_the_excerpt() : '';
$content      = apply_filters('the_content', get_the_content());

get_header();
?>

<main class="main">
    <div class="default-page relative isolate min-h-[40vh] overflow-hidden bg-white text-[#1D1D1F] transition-colors duration-200 dark:bg-black dark:text-[#F5F5F7] sm:min-h-[50vh]">

        <div class="pointer-events-none absolute inset-0" aria-hidden="true">
            <div class="absolute inset-0 bg-[linear-gradient(180deg,#F4F7FB_0%,#FFFFFF_42%,#FFFFFF_100%)] dark:bg-[linear-gradient(180deg,#12151A_0%,#000000_48%,#000000_100%)]"></div>
            <div class="absolute -left-[30%] top-[-12%] h-[280px] w-[280px] rounded-full bg-[radial-gradient(circle_at_center,rgba(147,197,253,0.4)_0%,rgba(147,197,253,0)_70%)] blur-2xl sm:-left-[12%] sm:top-[-8%] sm:h-[420px] sm:w-[420px] lg:h-[560px] lg:w-[560px] dark:bg-[radial-gradient(circle_at_center,rgba(56,100,140,0.35)_0%,rgba(56,100,140,0)_70%)]"></div>
            <div class="absolute -right-[28%] top-[2%] h-[240px] w-[260px] rounded-full bg-[radial-gradient(circle_at_center,rgba(251,207,232,0.35)_0%,rgba(251,207,232,0)_72%)] blur-2xl sm:right-[-10%] sm:top-[4%] sm:h-[360px] sm:w-[400px] lg:h-[480px] lg:w-[520px] dark:bg-[radial-gradient(circle_at_center,rgba(90,70,100,0.28)_0%,rgba(90,70,100,0)_72%)]"></div>
            <div class="absolute left-[20%] top-[22%] hidden h-[220px] w-[280px] rounded-full bg-[radial-gradient(circle_at_center,rgba(167,243,208,0.22)_0%,rgba(167,243,208,0)_70%)] blur-3xl sm:block sm:left-[35%] sm:top-[18%] sm:h-[280px] sm:w-[360px] lg:h-[320px] lg:w-[420px] dark:bg-[radial-gradient(circle_at_center,rgba(40,80,70,0.2)_0%,rgba(40,80,70,0)_70%)]"></div>
        </div>

        <div class="relative z-10 container mx-auto px-5 xl:px-10 2xl:px-0 pt-[100px] pb-[56px] sm:pt-[120px] sm:pb-[72px] lg:pt-[150px] lg:pb-[120px]">
            <div class="mx-auto max-w-[800px]">

                <div class="mb-8 flex flex-col items-center text-center sm:mb-12 md:mb-16">

                    <?php if ( ! empty($page_title) ) : ?>
                        <h1 class="text-[28px] font-medium leading-[1.15] tracking-tight text-[#0F172A] sm:text-[40px] md:text-[52px] lg:text-[60px] dark:text-white">
                            <?php echo esc_html($page_title); ?>
                        </h1>
                    <?php endif; ?>

                    <?php if( ! empty($page_excerpt) ) : ?>
                        <p class="mt-4 max-w-[560px] text-[15px] font-light leading-[1.65] text-[#4B5563] sm:mt-5 sm:text-[17px] sm:leading-[1.7] md:text-[18px] dark:text-white/65">
                            <?php echo esc_html($page_excerpt); ?>
                        </p>
                    <?php endif; ?>

                    <div class="mt-6 h-px w-full bg-gradient-to-r from-transparent via-[#0F172A]/35 to-transparent sm:mt-8 dark:via-white/40" aria-hidden="true"></div>
                </div>

                <?php if ( ! empty($content) ) : ?>
                    <div class="h-article">
                        <?php echo $content; ?>
                    </div>
                <?php endif; ?>

            </div>
        </div>

        <?php
        require PATH . '/components/burger-menu/component.php';
        require PATH . '/components/modal/component.php';
        ?>
    </div>
</main>

<?php get_footer(); ?>
