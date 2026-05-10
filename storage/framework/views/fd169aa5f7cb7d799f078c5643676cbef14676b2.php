<?php if(Session::has('success')): ?>
    <div class="alert alert-success">
        <?php echo e(Session::get('success')); ?>

    </div>
<?php endif; ?>

<?php if(Session::has('error')): ?>
    <div class="alert alert-danger">
        <?php echo e(Session::get('error')); ?>

    </div>
<?php endif; ?>
<?php /**PATH D:\Rayhan\Development\gamehub-cms-bkash\resources\views/_partials/flashMessage.blade.php ENDPATH**/ ?>