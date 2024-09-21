<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" data-key="t-menu"><?php echo app('translator')->get('translation.Menu'); ?></li>
                <li>
                    <a href="<?php echo e(route('admin.dashboard')); ?>">
                        <i data-feather="home"></i>
                        <span class="badge rounded-pill bg-soft-success text-success float-end">9+</span>
                        <span data-key="t-dashboard"><?php echo app('translator')->get('translation.Dashboards'); ?></span>
                    </a>
                </li>

                




                

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="users"></i>
                        <span data-key="t-contacts"><?php echo app('translator')->get('translation.Sale_Manage'); ?></span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="<?php echo e(route('admin.orders.active')); ?>" data-key="t-user-grid"><?php echo app('translator')->get('translation.Active_orders'); ?></a></li>
                        <li><a href="<?php echo e(route('admin.orders.history')); ?>" data-key="t-user-grid"><?php echo app('translator')->get('translation.History_orders'); ?></a></li>
                        <li><a href="<?php echo e(route('admin.orders.return')); ?>" data-key="t-user-grid"><?php echo app('translator')->get('translation.Sales_Return'); ?></a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="mail"></i>
                        <span data-key="t-email"><?php echo app('translator')->get('translation.Shipping_Manage'); ?></span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="<?php echo e(route('admin.deliveries.orders.active')); ?>" data-key="t-user-grid"><?php echo app('translator')->get('translation.Active_deliveries'); ?></a></li>
                        <li><a href="<?php echo e(route('admin.deliveries.orders.history')); ?>" data-key="t-user-grid"><?php echo app('translator')->get('translation.History_deliveries'); ?></a></li>
                        
                        
                    </ul>
                </li>



                <li>
                    <a href="<?php echo e(route('admin.planners.index')); ?>">
                        <i data-feather="calendar"></i>
                        <span data-key="t-calendar"><?php echo app('translator')->get('translation.Calendars'); ?></span>
                    </a>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="mail"></i>
                        <span data-key="t-email"><?php echo app('translator')->get('translation.Customer_Manage'); ?></span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="<?php echo e(route('admin.customers.index')); ?>" data-key="t-read-email"><?php echo app('translator')->get('translation.Customers'); ?></a></li>
                        <li><a href="<?php echo e(route('admin.customers.active.orders')); ?>" data-key="t-user-grid"><?php echo app('translator')->get('translation.Active_orders'); ?></a></li>
                        <li><a href="<?php echo e(route('admin.customers.history.orders')); ?>" data-key="t-user-grid"><?php echo app('translator')->get('translation.History_orders'); ?></a></li>
                        <li><a href="<?php echo e(route('admin.customers.order.return')); ?>" data-key="t-user-list"><?php echo app('translator')->get('translation.Sales_Return'); ?></a></li>
                        <li><a href="<?php echo e(route('admin.customers.items.all')); ?>" data-key="t-read-email"><?php echo app('translator')->get('translation.Product_Item_Manage_List'); ?></a></li>
                        

                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="mail"></i>
                        <span data-key="t-email"><?php echo app('translator')->get('translation.Rental_type_Manage'); ?></span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="<?php echo e(route('admin.rental_types.create')); ?>" data-key="t-inbox"><?php echo app('translator')->get('translation.Menu_Add'); ?></a></li>
                        <li><a href="<?php echo e(route('admin.rental_types.index')); ?>" data-key="t-read-email"><?php echo app('translator')->get('translation.Menu_List'); ?></a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="mail"></i>
                        <span data-key="t-email"><?php echo app('translator')->get('translation.Product_Manage'); ?></span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="<?php echo e(route('admin.products.create')); ?>" key="t-products"><?php echo app('translator')->get('translation.Product_Item_Manage_Add'); ?></a></li>
                        <li><a href="<?php echo e(route('admin.products.index')); ?>" data-key="t-product-detail"><?php echo app('translator')->get('translation.Product_Item_Manage_List'); ?></a></li>
                        <li><a href="<?php echo e(route('admin.categories.create')); ?>" data-key="t-inbox"><?php echo app('translator')->get('translation.Add_Category'); ?></a></li>
                        <li><a href="<?php echo e(route('admin.categories.index')); ?>" data-key="t-read-email"><?php echo app('translator')->get('translation.Categories'); ?></a></li>
                        <li><a href="<?php echo e(route('admin.sub_categories.create')); ?>" data-key="t-inbox"><?php echo app('translator')->get('translation.Add_Sub_Category'); ?></a></li>
                        <li><a href="<?php echo e(route('admin.sub_categories.index')); ?>" data-key="t-read-email"><?php echo app('translator')->get('translation.Sub_Categories'); ?></a></li>
                    </ul>
                </li>



                

                

                <li>
                    <a href="<?php echo e(route('admin.branches.index')); ?>" class="has-arrow">
                        <i data-feather="shopping-cart"></i>
                        <span data-key="t-ecommerce"><?php echo app('translator')->get('translation.Branch_Manage'); ?></span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="<?php echo e(route('admin.branches.create')); ?>" data-key="t-inbox"><?php echo app('translator')->get('translation.Add_Branch'); ?></a></li>
                        <li><a href="<?php echo e(route('admin.branches.index')); ?>" data-key="t-read-email"><?php echo app('translator')->get('translation.Branches'); ?></a></li>
                    </ul>

                </li>


                

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="mail"></i>
                        <span data-key="t-email"><?php echo app('translator')->get('translation.Tickets'); ?></span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="<?php echo e(route('admin.customers.tickets.index')); ?>" data-key="t-read-email"><?php echo app('translator')->get('translation.Customer_Tickets'); ?></a></li>
                        
                    </ul>
                </li>







                



                





                

                

                

                

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="mail"></i>
                        <span data-key="t-email"><?php echo app('translator')->get('translation.Faq_Manage'); ?></span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="<?php echo e(route('admin.faqs.create')); ?>" data-key="t-inbox"><?php echo app('translator')->get('translation.Menu_Add'); ?></a></li>
                        <li><a href="<?php echo e(route('admin.faqs.index')); ?>" data-key="t-read-email"><?php echo app('translator')->get('translation.Menu_List'); ?></a></li>
                        <li><a href="<?php echo e(route('admin.faqs.types.create')); ?>" data-key="t-inbox"><?php echo app('translator')->get('translation.Add_Category'); ?></a></li>
                        <li><a href="<?php echo e(route('admin.faqs.types.index')); ?>" data-key="t-read-email"><?php echo app('translator')->get('translation.Categories'); ?></a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="users"></i>
                        <span data-key="t-contacts"><?php echo app('translator')->get('translation.User_Management'); ?></span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="<?php echo e(route('admin.users.index')); ?>" data-key="t-user-grid"><?php echo app('translator')->get('translation.Users'); ?></a></li>
                        <li><a href="<?php echo e(route('admin.users.create')); ?>" data-key="t-user-grid"><?php echo app('translator')->get('translation.Add_User'); ?></a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="users"></i>
                        <span data-key="t-contacts"><?php echo app('translator')->get('translation.Role_Management'); ?></span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="<?php echo e(route('admin.roles.index')); ?>" data-key="t-read-email"><?php echo app('translator')->get('translation.Roles'); ?></a></li>
                        <li><a href="<?php echo e(route('admin.roles.create')); ?>" data-key="t-read-email"><?php echo app('translator')->get('translation.Add_Role'); ?></a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="users"></i>
                        <span data-key="t-contacts"><?php echo app('translator')->get('translation.Settings'); ?></span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="<?php echo e(route('admin.settings.index')); ?>" data-key="t-read-email"><?php echo app('translator')->get('translation.General_Settings'); ?></a></li>
                        
                        
                        
                        <li><a href="<?php echo e(route('admin.settings.change.password')); ?>" data-key="t-user-grid"><?php echo app('translator')->get('translation.Change_Password'); ?></a></li>
                    </ul>
                </li>
            </ul>

            
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
<?php /**PATH C:\xampp\htdocs\admin_template\resources\views/layouts/sidebar.blade.php ENDPATH**/ ?>