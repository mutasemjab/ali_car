<?php $__env->startSection('title'); ?>
<?php echo e(__('messages.products')); ?>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title card_title_center"> <?php echo e(__('messages.Add_New')); ?> <?php echo e(__('messages.products')); ?></h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <form action="<?php echo e(route('products.store')); ?>" method="post" enctype='multipart/form-data'>
            <div class="row">
                <?php echo csrf_field(); ?>
                <div class="form-group col-md-6">
                    <label for="category_id"> <?php echo e(__('messages.categories')); ?></label>
                    <select class="form-control" name="category" id="category_id">
                        <option value="">Select Parent Category</option>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($category->id); ?>"><?php echo e($category->name_ar); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="text-danger"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="form-group col-md-6">
                    <label for="unit_id"> <?php echo e(__('messages.unit')); ?></label>
                    <select class="form-control" name="unit" id="unit_id">
                        <option value="">Select Unit</option>
                        <?php $__currentLoopData = $units; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($unit->id); ?>"><?php echo e($unit->name_ar); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['unit'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="text-danger"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="form-group col-md-6">
                    <label for="number"> <?php echo e(__('messages.number')); ?></label>
                    <input name="number" id="number" class="form-control" value="<?php echo e(old('number')); ?>">
                    <?php $__errorArgs = ['number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="text-danger"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="form-group col-md-6">
                    <label for="name_ar"> <?php echo e(__('messages.Name_ar')); ?></label>
                    <input name="name_ar" id="name_ar" class="form-control" value="<?php echo e(old('name_ar')); ?>">
                    <?php $__errorArgs = ['name_ar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="text-danger"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="form-group col-md-6">
                    <label for="name_en"> <?php echo e(__('messages.Name_en')); ?></label>
                    <input name="name_en" id="name_en" class="form-control" value="<?php echo e(old('name_en')); ?>">
                    <?php $__errorArgs = ['name_en'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="text-danger"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>



                <div class="form-group col-md-6">
                    <label for="description_en"> <?php echo e(__('messages.description_en')); ?></label>
                    <textarea name="description_en" id="description_en" class="form-control" rows="8"><?php echo e(old('description_en')); ?></textarea>
                    <?php $__errorArgs = ['description_en'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="text-danger"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="form-group col-md-6">
                    <label for="description_ar"> <?php echo e(__('messages.description_ar')); ?></label>
                    <textarea name="description_ar" id="description_ar" class="form-control" rows="8"><?php echo e(old('description_ar')); ?></textarea>
                    <?php $__errorArgs = ['description_ar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="text-danger"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>



                <div class="form-group col-md-6">
                    <label for="tax"> <?php echo e(__('messages.tax')); ?> %</label>
                    <input name="tax" id="tax" class="form-control" value="<?php echo e(old('tax')); ?>">
                    <?php $__errorArgs = ['tax'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="text-danger"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="form-group col-md-6">
                    <label for="selling_price_for_user"> <?php echo e(__('messages.selling_price_for_user')); ?></label>
                    <input name="selling_price_for_user" id="selling_price_for_user" class="form-control" value="<?php echo e(old('selling_price_for_user')); ?>">
                    <?php $__errorArgs = ['selling_price_for_user'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="text-danger"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="form-group col-md-6">
                    <label for="min_order_for_user"> <?php echo e(__('messages.min_order_for_user')); ?></label>
                    <input name="min_order_for_user" id="min_order_for_user" class="form-control" value="<?php echo e(old('min_order_for_user')); ?>">
                    <?php $__errorArgs = ['min_order_for_user'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="text-danger"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

              


                <div class="form-group col-md-6">
                    <label for="status"> <?php echo e(__('messages.Status')); ?></label>
                    <select name="status" id="status" class="form-control">
                        <option value="">Select</option>
                        <option <?php if(old('status')==1 || old('status')==""): ?> selected="selected" <?php endif; ?> value="1">Active</option>
                        <option <?php if(old('status')==2 and old('status')!=""): ?> selected="selected" <?php endif; ?> value="2">Inactive</option>
                    </select>
                    <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="text-danger"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>


            </div>


            <div class="form-group col-md-12 text-center">
                <button id="do_add_item_cardd" type="submit" class="btn btn-primary"><?php echo e(__('messages.Submit')); ?></button>
                <a href="<?php echo e(route('products.index')); ?>" class="btn btn-danger"><?php echo e(__('messages.Cancel')); ?></a>
            </div>
        </form>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\ali_car\resources\views/admin/products/create.blade.php ENDPATH**/ ?>