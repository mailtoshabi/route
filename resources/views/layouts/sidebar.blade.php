<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" data-key="t-menu">@lang('translation.Menu')</li>
                <li>
                    <a href="{{ route('admin.dashboard') }}">
                        <i data-feather="home"></i>
                        <span class="badge rounded-pill bg-soft-success text-success float-end">9+</span>
                        <span data-key="t-dashboard">@lang('translation.Dashboards')</span>
                    </a>
                </li>

                {{-- <li class="menu-title" data-key="t-apps">@lang('translation.Apps')</li> --}}




                {{-- <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="users"></i>
                        <span data-key="t-contacts">@lang('translation.Sale_Manage')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('admin.batches.index') }}" data-key="t-user-grid">@lang('translation.Sales')</a></li>
                        <li><a href="{{ route('admin.orders.index') }}" data-key="t-user-grid">@lang('translation.Sales')</a></li>
                        <li><a href="{{ route('admin.sales.index') }}" data-key="t-user-grid">Sales</a></li>
                        <li><a href="{{ route('admin.sale_returns.index') }}" data-key="t-user-list">@lang('translation.Sales_Return')</a></li>
                    </ul>
                </li> --}}

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="users"></i>
                        <span data-key="t-contacts">@lang('translation.Sale_Manage')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('admin.orders.active') }}" data-key="t-user-grid">@lang('translation.Active_orders')</a></li>
                        <li><a href="{{ route('admin.orders.history') }}" data-key="t-user-grid">@lang('translation.History_orders')</a></li>
                        <li><a href="{{ route('admin.orders.return') }}" data-key="t-user-grid">@lang('translation.Sales_Return')</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="mail"></i>
                        <span data-key="t-email">@lang('translation.Shipping_Manage')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('admin.deliveries.orders.active') }}" data-key="t-user-grid">@lang('translation.Active_deliveries')</a></li>
                        <li><a href="{{ route('admin.deliveries.orders.history') }}" data-key="t-user-grid">@lang('translation.History_deliveries')</a></li>
                        {{-- <li><a href="{{ route('admin.drivers.index') }}" data-key="t-read-email">@lang('translation.Drivers')</a></li>
                        <li><a href="{{ route('admin.shippers.index') }}" data-key="t-user-grid">@lang('translation.Shipping_Organization')</a></li> --}}
                        {{-- <li><a href="{{ route('admin.drivers.create') }}" data-key="t-inbox">@lang('translation.Add_Driver')</a></li>
                        <li><a href="{{ route('admin.vehicles.index') }}" data-key="t-read-email">@lang('translation.Vehicles')</a></li>
                        <li><a href="{{ route('admin.drivers.tickets.index') }}" data-key="t-read-email">@lang('translation.Tickets')</a></li> --}}
                    </ul>
                </li>



                <li>
                    <a href="{{ route('admin.planners.index') }}">
                        <i data-feather="calendar"></i>
                        <span data-key="t-calendar">@lang('translation.Calendars')</span>
                    </a>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="mail"></i>
                        <span data-key="t-email">@lang('translation.Customer_Manage')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('admin.customers.index') }}" data-key="t-read-email">@lang('translation.Customers')</a></li>
                        <li><a href="{{ route('admin.customers.active.orders') }}" data-key="t-user-grid">@lang('translation.Active_orders')</a></li>
                        <li><a href="{{ route('admin.customers.history.orders') }}" data-key="t-user-grid">@lang('translation.History_orders')</a></li>
                        <li><a href="{{ route('admin.customers.order.return') }}" data-key="t-user-list">@lang('translation.Sales_Return')</a></li>
                        <li><a href="{{ route('admin.customers.items.all') }}" data-key="t-read-email">@lang('translation.Product_Item_Manage_List')</a></li>
                        {{-- <li><a href="{{ route('admin.customers.create') }}" data-key="t-inbox">@lang('translation.Menu_Add')</a></li> --}}

                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="mail"></i>
                        <span data-key="t-email">@lang('translation.Rental_type_Manage')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('admin.rental_types.create') }}" data-key="t-inbox">@lang('translation.Menu_Add')</a></li>
                        <li><a href="{{ route('admin.rental_types.index') }}" data-key="t-read-email">@lang('translation.Menu_List')</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="mail"></i>
                        <span data-key="t-email">@lang('translation.Product_Manage')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('admin.products.create') }}" key="t-products">@lang('translation.Product_Item_Manage_Add')</a></li>
                        <li><a href="{{ route('admin.products.index') }}" data-key="t-product-detail">@lang('translation.Product_Item_Manage_List')</a></li>
                        <li><a href="{{ route('admin.categories.create') }}" data-key="t-inbox">@lang('translation.Add_Category')</a></li>
                        <li><a href="{{ route('admin.categories.index') }}" data-key="t-read-email">@lang('translation.Categories')</a></li>
                        <li><a href="{{ route('admin.sub_categories.create') }}" data-key="t-inbox">@lang('translation.Add_Sub_Category')</a></li>
                        <li><a href="{{ route('admin.sub_categories.index') }}" data-key="t-read-email">@lang('translation.Sub_Categories')</a></li>
                    </ul>
                </li>



                {{-- <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="mail"></i>
                        <span data-key="t-email">@lang('translation.Category_Manage')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('admin.categories.create') }}" data-key="t-inbox">@lang('translation.Menu_Add')</a></li>
                        <li><a href="{{ route('admin.categories.index') }}" data-key="t-read-email">@lang('translation.Menu_List')</a></li>
                    </ul>
                </li> --}}

                {{-- <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="mail"></i>
                        <span data-key="t-email">@lang('translation.Sub_Category_Manage')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('admin.sub_categories.create') }}" data-key="t-inbox">@lang('translation.Menu_Add')</a></li>
                        <li><a href="{{ route('admin.sub_categories.index') }}" data-key="t-read-email">@lang('translation.Menu_List')</a></li>
                    </ul>
                </li> --}}

                <li>
                    <a href="{{ route('admin.branches.index') }}" class="has-arrow">
                        <i data-feather="shopping-cart"></i>
                        <span data-key="t-ecommerce">@lang('translation.Branch_Manage')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('admin.branches.create') }}" data-key="t-inbox">@lang('translation.Add_Branch')</a></li>
                        <li><a href="{{ route('admin.branches.index') }}" data-key="t-read-email">@lang('translation.Branches')</a></li>
                    </ul>

                </li>


                {{-- <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="shopping-cart"></i>
                        <span data-key="t-ecommerce">@lang('translation.Vendor_Manage')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('admin.sellers.request.list') }}" key="t-products">@lang('translation.Vednor_Request_List')</a></li>
                        <li><a href="{{ route('admin.sellers.approved.list') }}" key="t-products">@lang('translation.Vednor_Approved_List')</a></li>
                        <li><a href="{{ route('admin.products.items.all') }}" data-key="t-read-email">@lang('translation.Product_Item_Manage_List')</a></li>
                        <li><a href="{{ route('admin.branches.index') }}" data-key="t-read-email">@lang('translation.Branch_Manage')</a></li>
                    </ul>
                </li> --}}

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="mail"></i>
                        <span data-key="t-email">@lang('translation.Tickets')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('admin.customers.tickets.index') }}" data-key="t-read-email">@lang('translation.Customer_Tickets')</a></li>
                        {{-- <li><a href="{{ route('admin.sellers.tickets.index') }}" data-key="t-orders">@lang('translation.Seller_Tickets')</a></li> --}}
                    </ul>
                </li>







                {{-- <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="mail"></i>
                        <span data-key="t-email">@lang('translation.Branch_Manage')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('admin.branches.create') }}" data-key="t-inbox">@lang('translation.Add_Branch')</a></li>
                        <li><a href="{{ route('admin.branches.index') }}" data-key="t-read-email">@lang('translation.Branches')</a></li>
                        <li><a href="{{ route('admin.branches.active.orders') }}" data-key="t-user-grid">@lang('translation.Active_orders')</a></li>
                        <li><a href="{{ route('admin.branches.history.orders') }}" data-key="t-user-grid">@lang('translation.History_orders')</a></li>
                        <li><a href="{{ route('admin.branches.order.return') }}" data-key="t-user-list">@lang('translation.Sales_Return')</a></li>

                    </ul>
                </li> --}}



                {{-- <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="mail"></i>
                        <span data-key="t-email">@lang('translation.Brand_Manage')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('admin.brands.create') }}" data-key="t-inbox">@lang('translation.Menu_Add')</a></li>
                        <li><a href="{{ route('admin.brands.index') }}" data-key="t-read-email">@lang('translation.Menu_List')</a></li>
                    </ul>
                </li> --}}





                {{-- <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="users"></i>
                        <span data-key="t-contacts">@lang('translation.Offer_Management')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('admin.offers.index') }}" data-key="t-read-email">@lang('translation.Menu_List')</a></li>
                        <li><a href="{{ route('admin.offers.create') }}" data-key="t-user-grid">@lang('translation.Menu_Add')</a></li>
                    </ul>
                </li> --}}

                {{-- <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="mail"></i>
                        <span data-key="t-email">@lang('translation.Purchase_Manage')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('admin.purchases.index') }}" data-key="t-user-grid">@lang('translation.Purchases')</a></li>
                        <li><a href="{{ route('admin.purchases.create') }}" data-key="t-user-grid">@lang('translation.Add_Purchase')</a></li>
                        <li><a href="{{ route('admin.suppliers.index') }}" data-key="t-read-email">@lang('translation.Suppliers')</a></li>
                        <li><a href="{{ route('admin.suppliers.create') }}" data-key="t-inbox">@lang('translation.Menu_Add')</a></li>
                    </ul>
                </li> --}}

                {{-- //TODO: Create Ticket COntroller  --}}

                {{-- <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="mail"></i>
                        <span data-key="t-email">@lang('translation.Message_Manage')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('admin.messages.create') }}" data-key="t-inbox">@lang('translation.Menu_Add')</a></li>
                        <li><a href="{{ route('admin.messages.index') }}" data-key="t-read-email">@lang('translation.Menu_List')</a></li>
                    </ul>
                </li> --}}

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="mail"></i>
                        <span data-key="t-email">@lang('translation.Faq_Manage')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('admin.faqs.create') }}" data-key="t-inbox">@lang('translation.Menu_Add')</a></li>
                        <li><a href="{{ route('admin.faqs.index') }}" data-key="t-read-email">@lang('translation.Menu_List')</a></li>
                        <li><a href="{{ route('admin.faqs.types.create') }}" data-key="t-inbox">@lang('translation.Add_Category')</a></li>
                        <li><a href="{{ route('admin.faqs.types.index') }}" data-key="t-read-email">@lang('translation.Categories')</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="users"></i>
                        <span data-key="t-contacts">@lang('translation.User_Management')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('admin.users.index') }}" data-key="t-user-grid">@lang('translation.Users')</a></li>
                        <li><a href="{{ route('admin.users.create') }}" data-key="t-user-grid">@lang('translation.Add_User')</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="users"></i>
                        <span data-key="t-contacts">@lang('translation.Role_Management')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('admin.roles.index') }}" data-key="t-read-email">@lang('translation.Roles')</a></li>
                        <li><a href="{{ route('admin.roles.create') }}" data-key="t-read-email">@lang('translation.Add_Role')</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="users"></i>
                        <span data-key="t-contacts">@lang('translation.Settings')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('admin.settings.index') }}" data-key="t-read-email">@lang('translation.General_Settings')</a></li>
                        {{-- <li><a href="{{ route('admin.settings.delivery-charge.index') }}" data-key="t-read-email">@lang('translation.Delivery_Charge_Setup')</a></li> --}}
                        {{-- <li><a href="{{ route('admin.settings.tax-types.index') }}" data-key="t-read-email">@lang('translation.Tax_Type_Setup')</a></li> --}}
                        {{-- <li><a href="{{ route('admin.rent_products.rent_terms.index') }}" data-key="t-customers">@lang('translation.Rent_Terms')</a></li> --}}
                        <li><a href="{{ route('admin.settings.change.password') }}" data-key="t-user-grid">@lang('translation.Change_Password')</a></li>
                    </ul>
                </li>
            </ul>

            {{-- <div class="card sidebar-alert shadow-none text-center mx-4 mb-0 mt-5">
                <div class="card-body">
                    <img src="assets/images/giftbox.png" alt="">
                    <div class="mt-4">
                        <h5 class="alertcard-title font-size-16">Unlimited Access</h5>
                        <p class="font-size-13">Upgrade your plan from a Free trial, to select ‘Business Plan’.</p>
                        <a href="#!" class="btn btn-primary mt-2">Upgrade Now</a>
                    </div>
                </div>
            </div> --}}
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
