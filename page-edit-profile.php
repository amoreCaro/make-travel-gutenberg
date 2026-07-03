<?php

if (!defined('ABSPATH')) {
    exit;
}

/*
Template Name: Edit Profile (Travel Blog UI)
*/

if (!is_user_logged_in()) {
    wp_redirect(wp_login_url());
    exit;
}

$current_user = wp_get_current_user();
$user_id = $current_user->ID;
$user_nicename = $current_user->user_nicename;

get_header();
?>

<main class="main bg-white text-gray-900 min-h-screen font-sans antialiased">
    <div class="container px-5 xl:px-10 2xl:px-0 py-[100px] max-w-6xl mx-auto">

        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-12 gap-4">
            <div class="flex items-center gap-4">

                <a href="<?php echo esc_url( home_url('/author/' . $user_nicename ) ); ?>" class="w-12 h-12 rounded-full bg-[#0F172A] flex items-center justify-center text-white font-semibold text-lg">
                    <?php echo strtoupper(substr(esc_html( $user_nicename ), 0, 1)); ?>
                </a>

                <div>
                    <h1 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                        <span><?php echo esc_html( $user_nicename ); ?></span>
                        <span class="text-gray-300 font-light">/</span>
                        <span>Edit Profile</span>
                    </h1>

                    <p class="text-sm text-gray-500 mt-0.5">
                        Set up your travel blog profile, destinations, and storytelling identity
                    </p>
                </div>

            </div>
        </div>

        <div class="grid items-start gap-8 xl:grid-cols-[200px_minmax(0,1fr)]">

            <div class="w-full">
                <ul class="space-y-4">
                    <li><a href="#" class="text-sm font-medium text-gray-500 hover:text-gray-900 transition-colors">General</a></li>
                    <li><a href="#" class="text-sm font-bold text-gray-900">Edit Profile</a></li>
                    <li><a href="#" class="text-sm font-medium text-gray-500 hover:text-gray-900 transition-colors">Password</a></li>
                    <li><a href="#" class="text-sm font-medium text-gray-500 hover:text-gray-900 transition-colors">Travel Stories</a></li>
                    <li><a href="#" class="text-sm font-medium text-gray-500 hover:text-gray-900 transition-colors">Destinations</a></li>
                    <li><a href="#" class="text-sm font-medium text-gray-500 hover:text-gray-900 transition-colors">Notifications</a></li>
                </ul>
            </div>

            <!-- Form -->
            <section class="bg-white border border-gray-100 rounded-3xl p-10 shadow-sm max-w-3xl w-full">

                <form method="post" enctype="multipart/form-data" >
                    <?php wp_nonce_field('update_user_profile', 'update_profile_nonce'); ?>

                    <!-- PROFILE -->
                    <div class="mb-10">
                        <h2 class="text-[13px] font-bold tracking-wider uppercase text-gray-900 border-b border-gray-100 pb-4 mb-8">
                            Profile Basics
                        </h2>

                        <div class="flex items-center gap-4 mb-8">
                            <div class="w-24 h-24 rounded-full bg-[#0F172A] flex items-center justify-center text-white font-semibold text-3xl shadow-sm">
                                <?php echo strtoupper(substr(esc_html( $user_nicename ), 0, 1)); ?>
                            </div>

                            <div class="flex gap-3">
                                <button type="button" class="px-5 py-2.5 border border-gray-200 rounded-full text-xs font-bold text-gray-900 hover:bg-gray-50 hover:border-gray-300 transition">
                                    Upload new picture
                                </button>

                                <button type="button" class="px-5 py-2.5 bg-gray-50 rounded-full text-xs font-bold text-gray-900 hover:bg-gray-100 transition">
                                    Delete
                                </button>
                            </div>
                        </div>

                        <div class="space-y-6">

                            <!-- Name -->
                            <div>
                                <label class="block text-sm font-bold text-gray-900 mb-2">
                                    Name <span class="text-red-500">*</span>
                                </label>

                                <input
                                    type="text"
                                    name="nickname"
                                    value="<?php echo esc_attr($current_user->user_nicename); ?>"
                                    class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-1 focus:ring-gray-400"
                                    required
                                >
                            </div>

                            <!-- Location -->
                            <div>
                                <label class="block text-sm font-bold text-gray-900 mb-2">
                                    Location
                                </label>

                                <input
                                    type="text"
                                    name="location"
                                    value="Lviv, Ukraine"
                                    class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-1 focus:ring-gray-400"
                                >
                            </div>

                            <!-- Bio -->
                            <div>
                                <div class="flex justify-between items-center mb-2">
                                    <label class="text-sm font-bold text-gray-900">
                                        Bio
                                    </label>
                                    <span class="text-[11px] text-gray-400">0/1024</span>
                                </div>

                                <textarea
                                    name="bio"
                                    rows="5"
                                    placeholder="Tell your travel story..."
                                    class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-1 focus:ring-gray-400 resize-y"
                                ></textarea>

                                <p class="text-xs text-gray-400 mt-2">
                                    Brief description for your profile.
                                </p>
                            </div>

                        </div>
                    </div>

                    <!-- TRAVEL INFO / WORK HISTORY -->
                    <div class="mb-8">
                        <h2 class="text-[13px] font-bold tracking-wider uppercase text-gray-900 border-b border-gray-100 pb-4 mb-6">
                            Travel Experience
                        </h2>

                        <div class="space-y-6">

                            <div>
                                <h3 class="text-sm font-bold text-gray-900 mb-2">Visited Countries</h3>
                                <button type="button" class="text-sm text-gray-500 hover:text-gray-900 underline font-medium transition-colors">
                                    + Add countries
                                </button>
                            </div>

                            <div>
                                <h3 class="text-sm font-bold text-gray-900 mb-2">Favorite Destinations</h3>
                                <button type="button" class="text-sm text-gray-500 hover:text-gray-900 underline font-medium transition-colors">
                                    + Add destinations
                                </button>
                            </div>

                            <div>
                                <h3 class="text-sm font-bold text-gray-900 mb-2">Travel Style</h3>
                                <button type="button" class="text-sm text-gray-500 hover:text-gray-900 underline font-medium transition-colors">
                                    + Add style (budget, luxury, adventure, etc.)
                                </button>
                            </div>

                        </div>
                    </div>

                    <!-- SAVE -->
                    <div class="flex justify-end pt-4">
                        <button
                            type="submit"
                            class="px-6 py-3 hover:bg-[#2D2E3A] text-white text-sm font-bold rounded-full bg-black transition-colors shadow-sm"
                        >
                            Save Profile
                        </button>
                    </div>

                </form>

            </section>

        </div>

    </div>
</main>

<?php get_footer(); ?>