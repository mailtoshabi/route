<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="orderdetailsModalLabel">Order Details</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <p class="mb-2">Invoice id: <span class="text-primary">#{{ $sale->invoice_no }}</span></p>
            <p class="mb-2">Customer Name: <span class="text-primary">{{ $sale->customer->name }}</span></p>
            <p class="mb-4">Current Status: <span class="text-primary">{{ $sale->status_text }}</span></p>

            <div class="table-responsive">
                <table class="table align-middle table-nowrap">
                    <thead>
                        <tr>
                            <th scope="col">Product</th>
                            <th scope="col">Product Name</th>
                            <th scope="col">Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sale->products as $product)
                            <tr>
                                <th scope="row">
                                    <div>
                                        <img src="{{ URL::asset('/assets/images/product/img-7.png') }}" alt="" class="avatar-sm">
                                    </div>
                                </th>
                                <td>
                                    <div>
                                        <h5 class="text-truncate font-size-14">{{ $product->name }}</h5>
                                        <p class="text-muted mb-0">{{ $product->pivot->price . ' ' . Utility::CURRENCY_DISPLAY }}</p>
                                    </div>
                                </td>
                                <td>{{ $product->pivot->price . ' ' . Utility::CURRENCY_DISPLAY }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="2">
                                <h6 class="m-0 text-right">Sub Total:</h6>
                            </td>
                            <td>
                                {{ $sale->sale_total['price'] . ' ' . Utility::CURRENCY_DISPLAY }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <h6 class="m-0 text-right">Total VAT:</h6>
                            </td>
                            <td>
                                {{ $sale->sale_total['vat'] . ' ' . Utility::CURRENCY_DISPLAY }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <h6 class="m-0 text-right">Shipping:</h6>
                            </td>
                            <td>
                               {{ $sale->delivery_charge . ' ' . Utility::CURRENCY_DISPLAY }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <h6 class="m-0 text-right">Grand Total:</h6>
                            </td>
                            <td>
                                {{ ($sale->sale_total['price'] + $sale->sale_total['vat'] + $sale->delivery_charge) . ' ' . Utility::CURRENCY_DISPLAY }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
    </div>
</div>
