<?php $__env->startSection('title'); ?> <?php echo app('translator')->get('translation.Add_Product'); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
<link href="<?php echo e(URL::asset('assets/libs/select2/select2.min.css')); ?>" rel="stylesheet">
<link href="<?php echo e(URL::asset('assets/libs/dropzone/dropzone.min.css')); ?>" rel="stylesheet">
    <style>
        .hidden{
            display: none !important;
        }
        .close_container{
            position: relative;
        }
        .btn-close {
            position: absolute !important;
            right: 30px;
            top: 36px;
        }
    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<?php $__env->startComponent('components.breadcrumb'); ?>
<?php $__env->slot('li_1'); ?> <?php echo app('translator')->get('translation.Catalogue_Manage'); ?> <?php $__env->endSlot(); ?>
<?php $__env->slot('li_2'); ?> <?php echo app('translator')->get('translation.Product_Manage'); ?> <?php $__env->endSlot(); ?>
<?php $__env->slot('title'); ?> <?php echo app('translator')->get('translation.Add_Product'); ?> <?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>
<div class="row">
    <form method="POST" action="<?php echo e(isset($product)? route('admin.products.update') : route('admin.products.store')); ?>" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <?php if(isset($product)): ?>
            <input type="hidden" name="product_id" value="<?php echo e(encrypt($product->id)); ?>" />
            <input type="hidden" name="_method" value="PUT" />
        <?php endif; ?>
        
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Basic Information</h4>
                    <p class="card-title-desc">Fill all information below</p>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="name">Product Name</label>
                                <input id="name" name="name" type="text" class="form-control"  placeholder="Product Name" value="<?php echo e(isset($product)?$product->name:old('name')); ?>">
                                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-danger"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="mb-3">
                                <label for="name_ar">Product Name Arabic</label>
                                <input id="name_ar" name="name_ar" type="text" class="form-control"  placeholder="Product Name Arabic" value="<?php echo e(isset($product)?$product->name_ar:old('name_ar')); ?>">
                                <?php $__errorArgs = ['name_ar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-danger"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            

                            <div class="mb-3">
                                <label class="control-label">Ware house</label>
                                <select name="branch_id" id="branch_id" class="form-control select2">
                                    <option value="">Select</option>
                                    <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($branch->id); ?>" <?php echo e(isset($product)&&($product->branch_id==$branch->id)?'selected':''); ?>><?php echo e($branch->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['branch_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-danger"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="mb-3">
                                <label class="control-label">Sub Category</label>
                                <select name="sub_category_id" id="sub_category_id" class="form-control select2">
                                    <option value="">Select</option>
                                    <?php $__currentLoopData = $sub_categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub_category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($sub_category->id); ?>" <?php echo e(isset($product)&&($product->sub_category_id==$sub_category->id)?'selected':''); ?>><?php echo e($sub_category->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            


                            <div class="mb-3">
                                <label for="description">Product Description</label>
                                <textarea class="form-control" name="description" id="description" rows="5" placeholder="Product Description"><?php echo e(isset($product)?$product->description:old('description')); ?></textarea>
                            </div>
                        </div>

                        <div class="col-sm-6">

                            <div class="mb-3">
                                <label for="description_ar">Product Description Arabic</label>
                                <textarea class="form-control" name="description_ar" id="description_ar" rows="5" placeholder="Product Description Arabic"><?php echo e(isset($product)?$product->description_ar:old('description_ar')); ?></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="model_year">Modal year</label>
                                <input id="model_year" name="model_year" type="text" class="form-control" placeholder="Modal year" value="<?php echo e(isset($product)?$product->model_year:old('model_year')); ?>">
                            </div>

                            

                            
                            

                            <div class="mb-3">
                                <label for="barcode">Bar Code</label>
                                <input id="barcode" name="barcode" type="text" class="form-control" placeholder="Bar Code" value="<?php echo e(isset($product)?$product->barcode:old('barcode')); ?>">
                            </div>

                            

                            <div class="mb-3">
                                <label for="delivery_days">Delivery Days</label>
                                <input id="delivery_days" name="delivery_days" type="text" class="form-control" placeholder="Delivery Days" value="<?php echo e(isset($product)?$product->delivery_days:old('delivery_days')); ?>">
                            </div>
                            
                            
                            
                                
                            
                        </div>
                    </div>
                </div>
            </div>

            

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Product Image</h4>
                </div>
                <div class="card-body">

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="mb-3">
                                    <br><span id="imageContainer" <?php if(isset($product)&&empty($product->image)): ?> style="display: none" <?php endif; ?>>
                                        <?php if(isset($product)&&!empty($product->image)): ?>
                                            <img src="<?php echo e(URL::asset(App\Models\Product::DIR_STORAGE . $product->image)); ?>" alt="" class="avatar-xxl rounded-circle me-2">
                                            <button type="button" class="btn-close" aria-label="Close"></button>
                                        <?php endif; ?>
                                    </span>

                                    <span id="fileContainer" <?php if(isset($product)&&!empty($product->image)): ?> style="display: none" <?php endif; ?>>
                                        <input id="image" name="image" type="file" class="form-control"  placeholder="File">
                                        <?php if(isset($product)&&!empty($product->image)): ?>
                                            <button type="button" class="btn-close" aria-label="Close"></button>
                                        <?php endif; ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                </div>

            </div> <!-- end card-->

            


                

                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Prices</h4>
                        <p class="card-title-desc">Fill all information below</p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label for="price_day">Price Day</label>
                                    <input id="price_day" name="price_day" type="text" class="form-control"  placeholder="Price Day" value="<?php echo e(isset($product)?$product->price_day:old('price_day')); ?>">
                                    <?php $__errorArgs = ['price_day'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-danger"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label for="price_week">Price Week</label>
                                    <input id="price_week" name="price_week" type="text" class="form-control"  placeholder="Price Week" value="<?php echo e(isset($product)?$product->price_week:old('price_week')); ?>">
                                    <?php $__errorArgs = ['price_week'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-danger"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label for="price_month">Price Month</label>
                                    <input id="price_month" name="price_month" type="text" class="form-control"  placeholder="Price Month" value="<?php echo e(isset($product)?$product->price_month:old('price_month')); ?>">
                                    <?php $__errorArgs = ['price_month'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-danger"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>



                        </div>
                    </div>
                </div>

                <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Product Priorities</h4>
                    <p class="card-title-desc">Fill all information below</p>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <div class="form-group">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="is_trending" name="is_trending" value="1" <?php echo e(isset($product)&&($product->is_trending)?'checked':''); ?>>
                                        <label class="form-check-label" for="is_trending">Trending Product</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="mb-3">
                                <div class="form-group">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="is_featured" name="is_featured" value="1" <?php echo e(isset($product)&&($product->is_featured)?'checked':''); ?>>
                                        <label class="form-check-label" for="is_featured">Hot Deal</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="mb-3">
                                <div class="form-group">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="is_available" name="is_available" value="1" <?php echo e(isset($product)&&($product->is_available)?'checked':''); ?>>
                                        <label class="form-check-label" for="is_available">Is Available</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                
                                <input id="available_at" name="available_at" type="text" class="form-control" placeholder="Available At" value="<?php echo e(isset($product)?$product->available_at:old('available_at')); ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Meta Data</h4>
                    <p class="card-title-desc">Fill all information below</p>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="meta_title">Meta title</label>
                                <input id="meta_title" name="meta_title" type="text" class="form-control" placeholder="Meta Title" value="<?php echo e(isset($product)?$product->meta_title:old('meta_title')); ?>">
                            </div>
                            <div class="mb-3">
                                <label for="meta_keywords">Meta Keywords</label>
                                <input id="meta_keywords" name="meta_keywords" type="text" class="form-control" placeholder="Meta Keywords" value="<?php echo e(isset($product)?$product->meta_keywords:old('meta_keywords')); ?>">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="meta_description">Meta Description</label>
                                <textarea class="form-control" id="meta_description" rows="5" name="meta_description" placeholder="Meta Description"><?php echo e(isset($product)?$product->meta_description:old('meta_description')); ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            

            <div class="card">
                <div class="card-header">
                    <div class="d-flex flex-wrap gap-2">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Save Changes</button>
                        <button type="reset" class="btn btn-secondary waves-effect waves-light">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<!-- end row -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<script src="<?php echo e(URL::asset('assets/libs/select2/select2.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/libs/dropzone/dropzone.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/js/pages/ecommerce-select2.init.js')); ?>"></script>
<script src="<?php echo e(URL::asset('/assets/js/app.min.js')); ?>"></script>
<script>
    $(document).ready(function() {
        $('#imageContainer').find('button').click(function() {
            $('#imageContainer').hide();
            $('#fileContainer').show();
            $('input[name="isImageDelete"]').val(1);
        })

        $('#fileContainer').find('button').click(function() {
            $('#fileContainer').hide();
            $('#imageContainer').show();
            $('input[name="isImageDelete"]').val(0);
        })
    });
</script>

<script>
    $(document).ready(function() {
        $('.select2_rent_terms').select2();
        $(document).on("click", 'a[data-toggle="add-more"]', function(e) {
            e.stopPropagation();
            e.preventDefault();
            var $el = $($(this).attr("data-template")).clone();
            $el.removeClass("hidden");
            $el.attr("id", "");

            var count = $(this).data('count');
            count = typeof count == "undefined" ? 0 : count;
            count = count + 1;
            $(this).data('count', count);

            var addindex = $(this).data("addindex");
            if(typeof addindex == "object") {
                $.each(addindex, function(i, p) {
                    var have_child = p.have_child;
                    if(typeof(have_child)  === "undefined") {
                        $el.find(p.selector).attr(p.attr, p.value + '[' + count + ']');
                    }else {
                        $el.find(p.selector).attr(p.attr, p.value +'['+count+']'+'['+have_child+']' );
                    }
                });
            }

            var increment = $(this).data("increment");
            if(typeof increment == "object") {
                $.each(increment, function(i, p) {
                    var have_child = p.have_child;
                    if(typeof(have_child)  === "undefined") {
                        $el.find(p.selector).attr(p.attr, p.value +"-"+count);
                    }else {
                        $el.find(p.selector).attr(p.attr, p.value +"-"+count+"-"+have_child);
                    }
                });
            }

            var plugins = $(this).data("plugins");
            $.each(plugins, function(i, p) {
                if(p.plugin=='select2') {
                    //$el.find(p.selector).select2();
                }

            });

            $el.hide().appendTo($(this).attr("data-container")).fadeIn();

        });

        $(document).on('click','.btn-close',function(e) {
            e.preventDefault();
            var $this = $(this);
            var item_container = $(this).data('target');
            console.log(item_container);
            $(item_container).remove();
	    });

    })
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\admin_template\resources\views/admin/products/add.blade.php ENDPATH**/ ?>