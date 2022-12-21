

<?php $__env->startSection('content'); ?>
    <employer-job-post :prop-job-types='<?php echo json_encode($jobtypes, 15, 512) ?>' :prop-categories='<?php echo json_encode($categories, 15, 512) ?>'
        prop-company-id="<?php echo e($companyId); ?>" prop-qualifications='<?php echo json_encode($qualifications, 15, 512) ?>'>
    </employer-job-post>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app-employer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\eshen\Desktop\Github\trabahunt\resources\views/employer/employer-job-post.blade.php ENDPATH**/ ?>