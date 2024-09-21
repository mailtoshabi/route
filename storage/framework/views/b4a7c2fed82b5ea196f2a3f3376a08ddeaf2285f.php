<?php $__env->startSection('title'); ?> <?php echo app('translator')->get($active==1?'translation.Active_orders':'translation.History_orders'); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
<link href="<?php echo e(URL::asset('/assets/libs/datatables.net-bs4/datatables.net-bs4.min.css')); ?>" rel="stylesheet">
<link href="<?php echo e(URL::asset('assets/libs/datatables.net-responsive-bs4/datatables.net-responsive-bs4.min.css')); ?>" rel="stylesheet" type="text/css" />

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<?php $__env->startComponent('components.breadcrumb'); ?>
<?php $__env->slot('li_1'); ?> <?php echo app('translator')->get('translation.Sale_Manage'); ?> <?php $__env->endSlot(); ?>
<?php $__env->slot('title'); ?> <?php echo app('translator')->get($active==1?'translation.Active_orders':'translation.History_orders'); ?> <?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>
<?php if(session()->has('success')): ?> <p class="text-success"><?php echo e(session()->get('success')); ?> <?php endif; ?></p>
<div class="row">
    <div class="col-lg-12">
        <div class="card mb-0">
            <div class="card-body">
                 <div class="row align-items-center">
                     <div class="col-md-6">
                         <div class="mb-3">
                             <h5 class="card-title"><?php echo app('translator')->get($active==1?'translation.Active_orders':'translation.History_orders'); ?> <span class="text-muted fw-normal ms-2">(<?php echo e($orders->total()); ?>)</span></h5>
                         </div>
                     </div>

                     <div class="col-md-6">
                         <div class="d-flex flex-wrap align-items-center justify-content-end gap-2 mb-3">
                             
                             

                             
                         </div>

                     </div>
                 </div>
                 <!-- end row -->

                 <div class="table-responsive">
                    <table class="table align-middle table-nowrap table-check">
                        <thead class="table-light">
                            <tr>
                                
                                <th class="align-middle">Order Date</th>
                                <th class="align-middle">Order ID</th>
                                <th class="align-middle">Product</th>
                                <th class="align-middle">Seller</th>
                                <th class="align-middle">Customer</th>
                                <th class="align-middle">Customer Contact</th>
                                <th class="align-middle">Customer House No</th>
                                <th class="align-middle">Customer Location</th>
                                <th class="align-middle">Total</th>
                                <th class="align-middle">Payment Method</th>
                                <th class="align-middle">Payment Status</th>
                                <th class="align-middle">Order Status</th>
                                <th class="align-middle">Details</th>
                                <th class="align-middle">Invoice</th>
                            </tr>
                        </thead>
                         <tbody>
                             <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    
                                    <td><?php echo e($order->created_at->format('d-m-Y')); ?></td>
                                    <td>
                                        <a href="#" class="text-body"><?php echo e($order->invoice_no); ?></a>
                                    </td>
                                    <td><a href="#" class="text-body"><?php echo e($order->product->name); ?> </a></td>
                                    <td><a href="<?php echo e(route('admin.customers.view',encrypt($order->product->branch->customer->id))); ?>" target="_blank"><?php echo e($order->product->branch->customer->name); ?></a></td>
                                    <td><a href="<?php echo e(route('admin.customers.view',encrypt($order->sale->customer->id))); ?>" target="_blank"><?php echo e($order->sale->customer->name); ?></a></td>
                                    <td class="align-middle"><?php echo e($order->sale->customer->phone); ?></td>
                                    <td class="align-middle"><?php echo e($order->sale->customer->building_no); ?></td>
                                    <td class="align-middle"><?php echo e($order->sale->customer->city); ?></td>
                                    <td>
                                        <a href="#" class="text-body">
                                            <?php echo e($order->price . ' ' . Utility::CURRENCY_DISPLAY); ?>

                                        </a>
                                    </td>

                                    <td><?php echo $order->sale->payment_method_text; ?></td>
                                    <td><?php echo $order->is_paid?'<span class="badge badge-pill badge-soft-success font-size-12">Paid</span>':'<span class="badge badge-pill badge-soft-danger font-size-12">Not Paid</span>'; ?></td>
                                    <td class="align-middle"><span class="badge badge-pill badge-soft-primary font-size-12"><?php echo e(Utility::saleStatus()[$order->status]['name']); ?></span></td>
                                    <td>
                                        <a href="<?php echo e(route('admin.orders.show', encrypt($order->id))); ?>" class="btn btn-primary btn-sm btn-rounded" >
                                            View Details
                                        </a>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                            <div class="btn-group" role="group">
                                                <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    Invoice <i class="mdi mdi-chevron-down"></i>
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                    <li><a class="dropdown-item" onClick='showPopup(this.href);return(false);' href="<?php echo e(route('admin.orders.invoice.view_new', encrypt($order->id))); ?>" target="_blank">View Invoice</a></li>
                                                    <li><a class="dropdown-item" href="<?php echo e(route('admin.orders.download.invoice', encrypt($order->id))); ?>" target="_blank">Download Pdf</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                         </tbody>
                     </table>
                     <!-- end table -->
                     <div class="pagination justify-content-center"><?php echo e($orders->links()); ?></div>
                 </div>
                 <!-- end table responsive -->
            </div>
        </div>
    </div>
</div>

<div class="modal fade orderdetailsModal" tabindex="-1" role="dialog" aria-labelledby="orderdetailsModalLabel" aria-hidden="true">

</div><!-- /.modal -->

<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<script src="<?php echo e(URL::asset('assets/libs/datatables.net/datatables.net.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/libs/datatables.net-bs4/datatables.net-bs4.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/libs/datatables.net-responsive/datatables.net-responsive.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('/assets/js/app.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/js/pages/datatable-pages.init.js')); ?>"></script>
<script>
$(document).ready(function() {
    $(document).on('click','[data-plugin="render-modal"]',function(e) {
		e.preventDefault();
        var url = $(this).data('target');
        var modal_Id = $(this).data('modal');
        $.get(url, function (data) {
			var $el = $(data.html).clone();
			$(modal_Id).html($el);
			$(modal_Id).modal('show');
			// $(modal_Id).trigger('inside_modal.validation', $el);
		});
	});
});
</script>
<script type="text/javascript">
    function showPopup(url) {
    newwindow=window.open(url,'name','height=700,width=520,top=200,left=300,resizable');
    if (window.focus) {newwindow.focus()}
    }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\admin_template\resources\views/admin/orders/index.blade.php ENDPATH**/ ?>