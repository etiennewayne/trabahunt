<?php $__env->startSection('content'); ?>
    <welcome-page prop-categories='<?php echo json_encode($categories, 15, 512) ?>'
                  prop-job-types='<?php echo json_encode($jobTypes, 15, 512) ?>'></welcome-page>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\eshen\Desktop\Github\trabahunt\resources\views/welcome.blade.php ENDPATH**/ ?>