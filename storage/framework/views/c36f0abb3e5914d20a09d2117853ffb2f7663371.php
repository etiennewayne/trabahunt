<?php $__env->startSection('content'); ?>
    <employee-dashboard prop-user='<?php echo json_encode($user, 15, 512) ?>'></employee-dashboard>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app-employee', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\eshen\Desktop\Github\trabahunt\resources\views/employee/employee-dashboard.blade.php ENDPATH**/ ?>