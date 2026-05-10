<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed transition" dir="ltr" data-theme="theme-default"
    data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>
        <?php if(isset($title)): ?>
            <?php echo e($title); ?>

            |
        <?php endif; ?>
        Bkash Game</title>

    <meta name="description" content="" />
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?php echo e(asset('assets/img/favicon/favicon.ico')); ?>" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <!-- Icons. Uncomment required icon fonts -->
    <!-- Include Boxicons CSS -->
    <link href="<?php echo e(asset('assets/vendor/fonts/boxicons.css')); ?>" rel="stylesheet">

    <!-- Core CSS -->
    <link href="<?php echo e(asset('assets/vendor/css/core.css')); ?>" rel="stylesheet" class="template-customizer-core-css">
    <link href="<?php echo e(asset('assets/vendor/css/theme-default.css')); ?>" rel="stylesheet"
        class="template-customizer-theme-css">
    <link href="<?php echo e(asset('assets/css/demo.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('assets/css/responsive.css')); ?>" rel="stylesheet">

    <!-- Vendors CSS -->
    <link href="<?php echo e(asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('assets/vendor/libs/apex-charts/apex-charts.css')); ?>" rel="stylesheet">

    <!-- Helpers -->
    <script src="<?php echo e(asset('assets/vendor/js/helpers.js')); ?>"></script>
    <script src="<?php echo e(asset('js/moment.min.js')); ?>"></script>

    <!-- Template customizer & Theme config files -->
    <script src="<?php echo e(asset('assets/js/config.js')); ?>"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.1/xlsx.full.min.js"></script>

    
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <!-- Toastr CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />








    <!-- Scripts -->
    

</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar" id="app">
        <div class="layout-container">
            <?php echo $__env->make('layouts._partials.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->
                <?php echo $__env->make('layouts._partials.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <!-- / Navbar -->
                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->


                    <div class="px-3 container-p-y">
                        <?php if(session('success')): ?>
                            <div class="alert alert-success">
                                <?php echo e(session('success')); ?>

                            </div>
                        <?php endif; ?>
                        <?php if(session('error')): ?>
                            <div class="alert alert-danger">
                                <?php echo e(session('error')); ?>

                            </div>
                        <?php endif; ?>
                        <?php echo $__env->yieldContent('content'); ?>
                    </div>
                    <!-- / Content -->
                    <!-- Footer -->
                    <?php echo $__env->make('layouts._partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <!-- / Footer -->
                    <div class="content-backdrop fade"></div>
                </div>
            </div>
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <!-- Include Bootstrap CSS -->
    

    <!-- Include Perfect Scrollbar CSS -->
    <link href="<?php echo e(asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')); ?>" rel="stylesheet">

    <!-- Include Main CSS -->

    <!-- Endbuild -->

    <!-- Vendors JS -->
    <script src="<?php echo e(asset('assets/vendor/libs/jquery/jquery.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/vendor/libs/popper/popper.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/vendor/js/bootstrap.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/vendor/libs/apex-charts/apexcharts.js')); ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Main JS -->

    <!-- Page JS -->
    <script src="<?php echo e(asset('assets/js/dashboards-analytics.js')); ?>"></script>
    <script src="<?php echo e(asset('js/custom.js')); ?>"></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>

    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>



    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap4.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.3/moment.min.js"></script>



    
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>

</html>
<?php /**PATH D:\Rayhan\Development\gamehub-cms-bkash\resources\views/layouts/app.blade.php ENDPATH**/ ?>