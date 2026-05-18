</main>

<!-- Enhanced Minimalist Footer - Elegant & Professional -->
<footer class="mt-16 border-t border-slate-100 bg-white">
    <div class="container mx-auto px-6 py-10 md:py-12">
        <!-- Footer Grid - Subtle Branding & Links -->
        <div class="flex flex-col md:flex-row justify-between items-center gap-6 mb-8">
            <!-- Left Side - Brand & Tagline -->
            <div class="text-center md:text-left">
                <a href="<?= url('/') ?>" class="text-xl font-semibold tracking-tight text-slate-900 transition-opacity hover:opacity-75" style="font-family: 'Poppins', sans-serif;">
                    prosple<span style="font-weight: 300; color: #94a3b8;">.</span>
                </a>
                <p class="text-xs text-slate-400 mt-1.5 tracking-wide">
                    Connect talent with opportunity
                </p>
            </div>

            <!-- Center/Right - Simple Navigation Links (Optional but elegant) -->
            <div class="flex flex-wrap items-center justify-center gap-x-6 gap-y-2">
                <a href="<?= url('/') ?>" class="text-xs text-slate-500 transition-colors hover:text-slate-900" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                    Home
                </a>
                <a href="<?= url('listings') ?>" class="text-xs text-slate-500 transition-colors hover:text-slate-900" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                    Jobs
                </a>
                <a href="#" class="text-xs text-slate-500 transition-colors hover:text-slate-900" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                    About
                </a>
                <a href="#" class="text-xs text-slate-500 transition-colors hover:text-slate-900" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                    Contact
                </a>
                <span class="text-slate-300 text-xs">•</span>
                <a href="#" class="text-xs text-slate-500 transition-colors hover:text-slate-900" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                    Privacy
                </a>
            </div>
        </div>

        <!-- Divider with subtle gradient -->
        <div class="h-px bg-gradient-to-r from-transparent via-slate-200 to-transparent mb-6"></div>

        <!-- Copyright Section - Clean & Minimal -->
        <div class="flex flex-col sm:flex-row justify-between items-center gap-3 text-center sm:text-left">
            <p class="text-xs text-slate-400" style="font-family: 'Poppins', sans-serif;">
                &copy; 2024 Prosple. All rights reserved.
            </p>
            <p class="text-xs text-slate-400 flex items-center gap-1.5" style="font-family: 'Poppins', sans-serif;">
                <span class="inline-block w-1 h-1 rounded-full bg-emerald-400"></span>
                Empowering careers
            </p>
        </div>
    </div>
</footer>

<style>
    /* Ensure container styling matches overall design system */
    .container {
        max-width: 1280px;
        margin-left: auto;
        margin-right: auto;
    }

    @media (max-width: 768px) {
        .container {
            padding-left: 1rem;
            padding-right: 1rem;
        }
    }

    /* Smooth transitions for all interactive elements */
    footer a {
        transition: all 0.2s ease;
        text-decoration: none;
    }

    /* Optional: subtle hover underline effect for footer links */
    footer a:not(.brand):hover {
        text-decoration: underline;
        text-underline-offset: 3px;
    }
</style>

<script src="<?= asset('js/animations.js') ?>"></script>

</body>
</html>