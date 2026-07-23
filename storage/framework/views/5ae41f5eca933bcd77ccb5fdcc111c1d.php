

<?php $__env->startSection('content'); ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3">ຢືນຢັນອີເມວ</h5>

                    <p class="text-muted">
                        ກ່ອນທີ່ຈະເຂົ້າໃຊ້ລະບົບ, ກະລຸນາກວດອີເມວຂອງທ່ານ ແລະກົດລິ້ງຢືນຢັນບັນຊີ.  
                        ຖ້າທ່ານບໍ່ໄດ້ຮັບອີເມວ, ກົດປຸ່ມຂ້າງລຸ່ມເພື່ອສົ່ງລິ້ງໃໝ່.
                    </p>

                    
                    <?php if(session('status') == 'verification-link-sent'): ?>
                        <div class="alert alert-success" role="alert">
                            ✅ ພວກເຮົາໄດ້ສົ່ງລິ້ງຢືນຢັນໃໝ່ໄປຫາອີເມວຂອງທ່ານແລ້ວ!
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="<?php echo e(route('verification.send')); ?>">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn btn-primary">
                            ສົ່ງລິ້ງຢືນຢັນໃໝ່
                        </button>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\cash_center_v3\resources\views\auth\verify-email.blade.php ENDPATH**/ ?>