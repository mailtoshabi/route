<div class="row align-items-center">
    <div class="col-md-6">
        <div class="mb-3">
        <h5 class="card-title">Sellers Joining Request List <span class="text-muted fw-normal ms-2">({{ $sellers->count() }})</span></h5>
        </div>
    </div>

    {{-- <div class="col-md-6">
        <div class="d-flex flex-wrap align-items-center justify-content-end gap-2 mb-3">
            <div>
                <a href="{{ route('admin.sellers.create') }}" class="btn btn-light"><i class="bx bx-plus me-1"></i> Add New</a>
            </div>
        </div>
    </div> --}}
</div>
 <!-- end row -->

<div class="table-responsive mb-4">
    <table class="table align-middle dt-responsive table-check nowrap" style="border-collapse: collapse; border-spacing: 0 8px; width: 100%;">
        <thead>
        <tr>

            <th scope="col">Request ID</th>
            <th scope="col">Request Date</th>
            <th scope="col">Organization Name</th>
            <th scope="col">Owner/ID</th>
            <th scope="col">Items Type</th>
            <th scope="col">City/Country</th>
            <th scope="col">Location</th>
            {{-- <th scope="col">Documents</th> --}}
            <th scope="col">Status</th>
            <th class="align-middle">Details</th>
        </tr>
        </thead>
        <tbody>
           @foreach ($sellers as $index => $seller)
               <tr>
                   {{-- <th scope="row">
                       <div class="form-check font-size-16">
                           <input type="checkbox" class="form-check-input" id="contacusercheck{{$index}}">
                           <label class="form-check-label" for="contacusercheck{{$index}}"></label>
                       </div>
                   </th> --}}
                   <td>{{ $seller->request_id }}</td>
                   <td>{{ $seller->created_at->format('d-m-Y') }}</td>
                   <td>
                       {{-- @if(!empty($seller->image))
                           <img src="{{ URL::asset('storage/sellers/' . $seller->image) }}" alt="" class="avatar-sm rounded-circle me-2">
                       @else
                       <div class="avatar-sm d-inline-block align-middle me-2">
                           <div class="avatar-title bg-soft-primary text-primary font-size-20 m-0 rounded-circle">
                               <i class="bx bxs-user-circle"></i>
                           </div>
                       </div>
                       @endif --}}
                       <a href="#" class="text-body">{{ $seller->name }}</a>
                   </td>
                   <td>@if($seller->is_by_customer) {{ $seller->customer->name }}-{{ $seller->customer->id }} @else Seller By ADMIN @endif</td>
                   <td>
                        @foreach($seller->categories as $category)
                            {{ $category->name . ',' }}
                        @endforeach
                    </td>
                   <td>{{ $seller->city }} {{ $seller->country }}</td>
                   <td>{{ $seller->glocation }}</td>
                   {{-- <td>
                    ID NO : {{ $seller->id_number }} <a href="#" target="_blank"><small>View</small></a><br>
                    License NO : {{ $seller->license_number }}  <a href="#" target="_blank"><small>View</small></a><br>
                    Reg NO : {{ $seller->registration_number }}  <a href="#" target="_blank"><small>View</small></a>
                    </td> --}}
                   <td>{{ Utility::sellerStatus()[$seller->status]['name'] }}</td>
                   <td>
                    <a href="{{ route('admin.sellers.show',encrypt($seller->id)) }}" class="btn btn-primary btn-sm btn-rounded" >
                        View Details
                    </a>
                </td>
               </tr>
           @endforeach
        </tbody>
    </table>
    <!-- end table -->
    <div class="pagination justify-content-center">{{ $sellers->links() }}</div>
</div>
 <!-- end table responsive -->
