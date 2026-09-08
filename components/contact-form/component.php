<?php

if (!defined('ABSPATH')) {
    exit;
}

use Carbon_Fields\Block;
use Carbon_Fields\Field;

Block::make(__('Contact Form', THEME))

    ->add_tab(__('Content', THEME), [

        Field::make('text', 'title', __('Title', THEME))
            ->set_default_value(__('Mail to Us', THEME)),

        Field::make('textarea', 'subtitle', __('Subtitle', THEME))
            ->set_rows(2)
            ->set_default_value(
                __('Tell us what you’re planning, pitching, or wondering.', THEME)
            ),

    ])

    ->add_tab(__('Name field', THEME), [

        Field::make('text', 'name_label', __('Label', THEME))
            ->set_width(33)
            ->set_default_value(__('Full Name', THEME)),

        Field::make('text', 'name_placeholder', __('Placeholder', THEME))
            ->set_width(33)
            ->set_default_value(__('Your Full Name', THEME)),

        Field::make('text', 'name_error', __('Error message', THEME))
            ->set_width(33)
            ->set_default_value(__('Please enter your name.', THEME)),

    ])

    ->add_tab(__('Email field', THEME), [

        Field::make('text', 'email_label', __('Label', THEME))
            ->set_width(33)
            ->set_default_value(__('Email Address', THEME)),

        Field::make('text', 'email_placeholder', __('Placeholder', THEME))
            ->set_width(33)
            ->set_default_value(__('you@example.com', THEME)),

        Field::make('text', 'email_error', __('Error message', THEME))
            ->set_width(33)
            ->set_default_value(
                __('Please enter a valid email address.', THEME)
            ),

    ])

    ->add_tab(__('Message field', THEME), [

        Field::make('text', 'message_label', __('Label', THEME))
            ->set_width(33)
            ->set_default_value(__('Message', THEME)),

        Field::make('text', 'message_placeholder', __('Placeholder', THEME))
            ->set_width(33)
            ->set_default_value(__('Write Your Message...', THEME)),

        Field::make('text', 'message_error', __('Error message', THEME))
            ->set_width(33)
            ->set_default_value(
                __('Please enter a message.', THEME)
            ),

    ])

    ->add_tab(__('Actions & Status', THEME), [

        Field::make('text', 'submit', __('Submit button', THEME))
            ->set_width(50)
            ->set_default_value(__('Send Message', THEME)),

        Field::make('text', 'sending', __('Sending label', THEME))
            ->set_width(50)
            ->set_default_value(__('Sending…', THEME)),

        Field::make('text', 'success', __('Success message', THEME))
            ->set_default_value(
                __('Thanks! Your message has been sent.', THEME)
            ),

        Field::make('text', 'error_generic', __('Generic error', THEME))
            ->set_width(50)
            ->set_default_value(
                __('Something went wrong. Please try again.', THEME)
            ),

        Field::make('text', 'error_network', __('Network error', THEME))
            ->set_width(50)
            ->set_default_value(
                __('Network error. Please try again.', THEME)
            ),

    ])

    ->set_category('common')
    ->set_icon('email-alt')

    ->set_render_callback(function ($fields) {

        /*
         * Content
         */
        $title    = $fields['title'] ?? '';
        $subtitle = $fields['subtitle'] ?? '';


        /*
         * Name
         */
        $name_label       = $fields['name_label'] ?? '';
        $name_placeholder = $fields['name_placeholder'] ?? '';
        $name_error       = $fields['name_error'] ?? '';


        /*
         * Email
         */
        $email_label       = $fields['email_label'] ?? '';
        $email_placeholder = $fields['email_placeholder'] ?? '';
        $email_error       = $fields['email_error'] ?? '';


        /*
         * Message
         */
        $message_label       = $fields['message_label'] ?? '';
        $message_placeholder = $fields['message_placeholder'] ?? '';
        $message_error       = $fields['message_error'] ?? '';


        /*
         * Actions
         */
        $submit        = $fields['submit'] ?? '';
        $sending       = $fields['sending'] ?? '';
        $success       = $fields['success'] ?? '';
        $error_generic = $fields['error_generic'] ?? '';
        $error_network = $fields['error_network'] ?? '';


        /*
         * Classes
         */
        $input_class = 'form__input contact-form__input w-full rounded-xl border border-[#D1D5DB] bg-transparent px-4 py-3.5 text-[16px] text-[#111827] placeholder:text-[#9CA3AF] outline-none transition-colors duration-200 hover:border-[#9CA3AF] focus:border-black dark:border-white/20 dark:text-white dark:placeholder:text-white/40 dark:hover:border-white/40 dark:focus:border-white';

        $label_class = 'mb-1.5 block text-[12px] font-semibold capitalize text-[#111827] dark:text-white';

        ?>

        <section
            class="contact-form-section bg-white text-[#111827] dark:bg-black dark:text-white"
        >

            <div
                class="flex w-full flex-col"
            >

                <div class="mb-10 max-w-[720px] sm:mb-12 lg:mb-14">

                    <?php if (!empty($title)) : ?>

                        <h2
                            class="text-[24px] font-semibold leading-[1.15] tracking-tight text-[#111827] dark:text-white sm:text-[28px] md:text-[32px]"
                        >
                            <?php echo esc_html($title); ?>
                        </h2>

                    <?php endif; ?>


                    <?php if (!empty($subtitle)) : ?>

                        <p
                            class="mt-4 max-w-[520px] text-[15px] leading-relaxed text-[#6B7280] dark:text-white/55 sm:mt-5 sm:text-[17px]"
                        >
                            <?php echo esc_html($subtitle); ?>
                        </p>

                    <?php endif; ?>

                </div>


                <form
                    id="contactForm"
                    class="contact-form flex w-full max-w-[640px] flex-col lg:max-w-[720px]"
                    novalidate
                >

                    <div class="flex flex-col gap-8 sm:gap-10">


                        <!-- Name -->

                        <div>

                            <label
                                for="contact_name"
                                class="<?php echo esc_attr($label_class); ?>"
                            >
                                <?php echo esc_html($name_label); ?>

                                <span
                                    class="text-red-500"
                                    aria-hidden="true"
                                >
                                    *
                                </span>
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


                        <!-- Email -->

                        <div>

                            <label
                                for="contact_email"
                                class="<?php echo esc_attr($label_class); ?>"
                            >
                                <?php echo esc_html($email_label); ?>

                                <span
                                    class="text-red-500"
                                    aria-hidden="true"
                                >
                                    *
                                </span>
                            </label>

                            <input
                                type="email"
                                id="contact_email"
                                name="email"
                                required
                                autocomplete="email"
                                class="<?php echo esc_attr($input_class); ?>"
                                placeholder="<?php echo esc_attr($email_placeholder); ?>"
                            >

                        </div>


                        <!-- Message -->

                        <div>

                            <label
                                for="contact_message"
                                class="<?php echo esc_attr($label_class); ?>"
                            >
                                <?php echo esc_html($message_label); ?>

                                <span
                                    class="text-red-500"
                                    aria-hidden="true"
                                >
                                    *
                                </span>
                            </label>

                            <textarea
                                id="contact_message"
                                name="message"
                                required
                                rows="5"
                                class="<?php echo esc_attr($input_class); ?> min-h-[160px] resize-y"
                                placeholder="<?php echo esc_attr($message_placeholder); ?>"
                            ></textarea>

                        </div>

                    </div>


                    <!-- Honeypot -->

                    <div
                        class="absolute -left-[9999px] h-0 w-0 overflow-hidden"
                        aria-hidden="true"
                    >

                        <label for="contact_website">
                            <?php esc_html_e('Website', THEME); ?>
                        </label>

                        <input
                            type="text"
                            id="contact_website"
                            name="website"
                            tabindex="-1"
                            autocomplete="off"
                        >

                    </div>


                    <!-- Submit -->

                    <div class="mt-12 sm:mt-14">

                        <button
                            type="submit"
                            class="contact-form__submit group inline-flex w-fit items-center gap-3 rounded-full border border-black/85 bg-transparent px-6 py-3.5 text-xs font-medium tracking-[0.16em] text-black transition-colors duration-300 hover:border-black hover:bg-black hover:text-white disabled:cursor-not-allowed disabled:opacity-60 dark:border-white/85 dark:text-white dark:hover:border-white dark:hover:bg-white dark:hover:text-black md:text-sm"
                        >

                            <span>
                                <?php echo esc_html($submit); ?>
                            </span>

                            <svg
                                class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1"
                                viewBox="0 0 24 24"
                                fill="none"
                                aria-hidden="true"
                            >
                                <path
                                    d="M5 12h14M13 6l6 6-6 6"
                                    stroke="currentColor"
                                    stroke-width="1.5"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                />
                            </svg>

                        </button>


                        <!-- Success -->

                        <div
                            class="contact-form__success mt-5 hidden items-center rounded-xl border border-[#bbf7d0] bg-[#f0fdf4] p-4"
                            role="alert"
                        >

                            <div
                                class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-[#dcfce7] text-[#16a34a]"
                            >
                                <svg
                                    class="h-6 w-6"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="2.5"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M5 13l4 4L19 7"
                                    />
                                </svg>
                            </div>

                            <div class="ms-4 text-left">

                                <p class="text-sm text-[#15803d]">
                                    <?php echo esc_html($success); ?>
                                </p>

                            </div>

                        </div>


                        <!-- Sending -->

                        <div
                            class="contact-form__loading mt-5 hidden items-center rounded-xl border border-[#bfdbfe] bg-[#eff6ff] p-4"
                            role="status"
                        >

                            <div
                                class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-[#dbeafe] text-[#2563eb]"
                            >
                                <svg
                                    class="h-6 w-6 animate-spin"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <circle
                                        class="opacity-25"
                                        cx="12"
                                        cy="12"
                                        r="10"
                                        stroke="currentColor"
                                        stroke-width="4"
                                    />

                                    <path
                                        class="opacity-75"
                                        fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.343 5.824 3 7.938l-2.647-3.647z"
                                    />
                                </svg>
                            </div>

                            <div class="ms-4 text-left">

                                <p class="text-sm font-semibold text-[#1d4ed8]">
                                    <?php echo esc_html($sending); ?>
                                </p>

                                <p class="mt-0.5 text-xs font-medium text-[#93c5fd]">
                                    <?php esc_html_e(
                                        'Please wait, it will only take a moment',
                                        THEME
                                    ); ?>
                                </p>

                            </div>

                        </div>


                        <!-- Error -->

                        <div
                            class="contact-form__error mt-5 hidden items-center rounded-xl border border-[#fecaca] bg-[#fef2f2] p-4"
                            role="alert"
                        >

                            <div
                                class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-[#fee2e2] text-[#dc2626]"
                            >
                                <svg
                                    class="h-6 w-6"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="2.5"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"
                                    />
                                </svg>
                            </div>

                            <div class="ms-4 text-left">

                                <p class="contact-form__error-text text-sm text-[#b91c1c]">
                                    <?php echo esc_html($error_generic); ?>
                                </p>

                            </div>

                        </div>

                    </div>

                </form>

            </div>

        </section>

        <?php
    });