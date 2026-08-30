<?php

/**
 * Contact form popup — full-screen white panel, slides from top.
 *
 * @package Make_Travel
 */

if (!defined('ABSPATH')) {
    exit;
}

$input_class = 'form__input contact-form__input w-full rounded-xl border border-[#D1D5DB] bg-transparent px-4 py-3.5 text-[16px] text-[#111827] placeholder:text-[#9CA3AF] outline-none transition-colors duration-200 hover:border-[#9CA3AF] focus:border-black dark:border-white/20 dark:text-white dark:placeholder:text-white/40 dark:hover:border-white/40 dark:focus:border-white';
$textarea_class = 'form__input contact-form__input w-full rounded-xl border border-[#D1D5DB] bg-transparent px-4 py-3.5 text-[16px] text-[#111827] placeholder:text-[#9CA3AF] outline-none transition-colors duration-200 hover:border-[#9CA3AF] focus:border-black dark:border-white/20 dark:text-white dark:placeholder:text-white/40 dark:hover:border-white/40 dark:focus:border-white';
$label_class = 'mb-1.5 block text-[12px] font-semibold capitalize  text-[#111827] dark:text-white';

$modal_title         = carbon_get_the_post_meta('contact_modal_title');
$modal_subtitle      = carbon_get_the_post_meta('contact_modal_subtitle');
$name_label          = carbon_get_the_post_meta('contact_modal_name_label');
$name_placeholder    = carbon_get_the_post_meta('contact_modal_name_placeholder');
$email_label         = carbon_get_the_post_meta('contact_modal_email_label');
$email_placeholder   = carbon_get_the_post_meta('contact_modal_email_placeholder');
$message_label       = carbon_get_the_post_meta('contact_modal_message_label');
$message_placeholder = carbon_get_the_post_meta('contact_modal_message_placeholder');
$submit_label        = carbon_get_the_post_meta('contact_modal_submit');
$close_label         = carbon_get_the_post_meta('contact_modal_close');
$success_label       = carbon_get_the_post_meta('contact_modal_success');
$sending_label       = carbon_get_the_post_meta('contact_modal_sending');
$error_generic       = carbon_get_the_post_meta('contact_modal_error_generic');
?>

<div
    id="contactPopup"
    class="contact-popup fixed inset-0 z-[9999] flex flex-col bg-white opacity-0 pointer-events-none -translate-y-full transition-[opacity,transform] duration-[380ms] ease-[cubic-bezier(0.22,1,0.36,1)] data-[open=true]:opacity-100 data-[open=true]:pointer-events-auto data-[open=true]:translate-y-0 dark:bg-black"
    role="dialog"
    aria-modal="true"
    aria-labelledby="contactPopupTitle"
    data-open="false"
    hidden
>
    <button
        type="button"
        id="closeContactPopup"
        class="absolute right-5 top-5 z-20 inline-flex h-11 w-11 items-center justify-center rounded-lg text-[#6B7280] transition-colors hover:bg-[#F3F4F6] hover:text-[#111827] dark:text-white/50 dark:hover:bg-white/10 dark:hover:text-white sm:right-8 sm:top-8 lg:right-10 lg:top-10"
        aria-label="<?php echo esc_attr($close_label); ?>"
    >
        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </button>

    <div class="relative flex min-h-0 flex-1 flex-col overflow-y-auto">
        <div class="flex w-full flex-1 flex-col px-6 pb-14 pt-[88px] sm:px-10 sm:pt-[110px] md:px-14 lg:px-20 xl:px-24 2xl:px-32">
            <div class="mb-10 max-w-[720px] sm:mb-12 lg:mb-14">
                <?php if ($modal_title !== '') : ?>
                    <h2 id="contactPopupTitle" class="text-[24px] font-semibold leading-[1.15] tracking-tight text-[#111827] dark:text-white sm:text-[28px] md:text-[32px]">
                        <?php echo esc_html($modal_title); ?>
                    </h2>
                <?php endif; ?>
                <?php if ($modal_subtitle !== '') : ?>
                    <p class="mt-4 max-w-[520px] text-[15px] leading-relaxed text-[#6B7280] dark:text-white/55 sm:mt-5 sm:text-[17px]">
                        <?php echo esc_html($modal_subtitle); ?>
                    </p>
                <?php endif; ?>
            </div>

            <form
                id="contactForm"
                class="contact-form flex w-full max-w-[640px] flex-col lg:max-w-[720px]"
                novalidate
            >
                <div class="flex flex-col gap-8 sm:gap-10">
                    <div>
                        <label for="contact_name" class="<?php echo esc_attr($label_class); ?>">
                            <?php echo esc_html($name_label); ?> <span class="text-red-500" aria-hidden="true">*</span>
                        </label>
                        <input
                            type="text"
                            id="contact_name"
                            name="name"
                            required
                            autocomplete="name"
                            class="<?php echo esc_attr($input_class); ?>"
                            placeholder="<?php echo esc_attr($name_placeholder); ?>"
                        >
                    </div>

                    <div>
                        <label for="contact_email" class="<?php echo esc_attr($label_class); ?>">
                            <?php echo esc_html($email_label); ?> <span class="text-red-500" aria-hidden="true">*</span>
                        </label>
                        <input
                            type="email"
                            id="contact_email"
                            name="email"
                            required
                            autocomplete="email"
                            class="form__input-email <?php echo esc_attr($input_class); ?>"
                            placeholder="<?php echo esc_attr($email_placeholder); ?>"
                        >
                    </div>

                    <div>
                        <label for="contact_message" class="<?php echo esc_attr($label_class); ?>">
                            <?php echo esc_html($message_label); ?> <span class="text-red-500" aria-hidden="true">*</span>
                        </label>
                        <textarea
                            id="contact_message"
                            name="message"
                            required
                            rows="5"
                            class="<?php echo esc_attr($textarea_class); ?> min-h-[160px] resize-y"
                            placeholder="<?php echo esc_attr($message_placeholder); ?>"
                        ></textarea>
                    </div>
                </div>

                <div class="absolute -left-[9999px] h-0 w-0 overflow-hidden" aria-hidden="true">
                    <label for="contact_website"><?php esc_html_e('Website', THEME); ?></label>
                    <input type="text" id="contact_website" name="website" tabindex="-1" autocomplete="off">
                </div>

                <div class="mt-12 sm:mt-14">
                    <button
                        type="submit"
                        class="contact-form__submit group inline-flex items-center gap-3 w-fit px-6 py-3.5 text-xs md:text-sm font-medium tracking-[0.16em] capitalize rounded-full border border-black/85 bg-transparent text-black hover:bg-black hover:border-black hover:text-white transition-colors duration-300 dark:border-white/85 dark:text-white dark:hover:bg-white dark:hover:border-white dark:hover:text-black disabled:cursor-not-allowed disabled:opacity-60"
                    >
                        <span><?php echo esc_html($submit_label); ?></span>
                        <svg class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-1" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>

                    <div class="popup-success hidden flex items-center p-4 mt-5 mb-0 rounded-xl border border-[#bbf7d0] bg-[#f0fdf4] shadow-sm shadow-[#dcfce7]" role="alert">
                        <div class="flex-shrink-0 w-10 h-10 flex items-center justify-center rounded-full bg-[#dcfce7] text-[#16a34a]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <div class="ms-4 text-left">
                            <p class="text-sm text-[#15803d]"><?php echo esc_html($success_label); ?></p>
                        </div>
                    </div>

                    <div class="popup-info hidden flex items-center p-4 mt-5 mb-0 rounded-xl border border-[#bfdbfe] bg-[#eff6ff] shadow-sm shadow-[#dbeafe]" role="alert">
                        <div class="flex-shrink-0 w-10 h-10 flex items-center justify-center rounded-full bg-[#dbeafe] text-[#2563eb]">
                            <svg style="animation: spin 1s linear infinite;" class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <style>
                                    @keyframes spin {
                                        from { transform: rotate(0deg); }
                                        to { transform: rotate(360deg); }
                                    }
                                </style>
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </div>
                        <div class="ms-4 text-left">
                            <p class="text-sm font-semibold text-[#1d4ed8] leading-tight">
                                <?php echo esc_html($sending_label); ?>
                            </p>
                            <p class="text-xs text-[#93c5fd] mt-0.5 font-medium">
                                <?php esc_html_e('Please wait, it will only take a moment', THEME); ?>
                            </p>
                        </div>
                    </div>

                    <div class="popup-error hidden flex items-center p-4 mt-5 mb-0 rounded-xl border border-[#fecaca] bg-[#fef2f2] shadow-sm shadow-[#fee2e2]" role="alert">
                        <div class="flex-shrink-0 w-10 h-10 flex items-center justify-center rounded-full bg-[#fee2e2] text-[#dc2626]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="ms-4 text-left">
                            <p class="popup-error__text text-sm text-[#b91c1c]">
                                <?php echo esc_html($error_generic); ?>
                            </p>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
