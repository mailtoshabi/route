@extends('layouts.master')
@section('title') Ticket #{{ $ticket->ticket_id}} @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') @lang('translation.Driver_Manage') @endslot
@slot('li_2') @lang('translation.Tickets') @endslot
@slot('title') Ticket #{{ $ticket->ticket_id}} @endslot
@endcomponent
<div class="row">
    <div class="col-xl-12">

        <!-- Right Sidebar -->
        <div class=" mb-3">

            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        <div class="flex-shrink-0 me-3">
                            @if(!empty($ticket->driver->image))
                                <img src="{{ URL::asset('storage/drivers/' . $ticket->driver->image) }}" alt="" class="rounded-circle avatar-sm">
                            @else
                                <div class="avatar-sm d-inline-block align-middle me-2">
                                    <div class="avatar-title bg-soft-primary text-primary font-size-20 m-0 rounded-circle">
                                        <i class="bx bxs-user-circle"></i>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="font-size-14 mb-0">{{ $ticket->driver->name }}</h5>
                            <small class="text-muted">{{ $ticket->driver->email }}</small>
                        </div>
                    </div>

                    <h4 class="font-size-16">{{ $ticket->title }}</h4>
                    {!! $ticket->description !!}

                    <p style="text-align:right;">Posted On {{ $ticket->created_at->format('d-m-Y') }}</p>
                    <hr/>
                </div>

                @if (!empty($ticket->replies))
                    @foreach ($ticket->replies as $reply)
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-4">
                                <div class="flex-shrink-0 me-3">
                                    @if ($reply->user_id)
                                        @if(!empty(auth()->user()->avatar))
                                            <img src="{{ URL::asset('storage/users/' . auth()->user()->avatar ) }}" alt="" class="rounded-circle avatar-sm">
                                        @else
                                            <div class="avatar-sm d-inline-block align-middle me-2">
                                                <div class="avatar-title bg-soft-primary text-primary font-size-20 m-0 rounded-circle">
                                                    <i class="bx bxs-user-circle"></i>
                                                </div>
                                            </div>
                                        @endif
                                    @else
                                        @if(!empty($ticket->driver->image))
                                            <img src="{{ URL::asset('storage/drivers/' . $ticket->driver->image) }}" alt="" class="rounded-circle avatar-sm">
                                        @else
                                            <div class="avatar-sm d-inline-block align-middle me-2">
                                                <div class="avatar-title bg-soft-primary text-primary font-size-20 m-0 rounded-circle">
                                                    <i class="bx bxs-user-circle"></i>
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="font-size-14 mb-0">{{ $reply->user_id ? ucfirst(auth()->user()->name) :  $ticket->driver->name}}</h5>
                                    <small class="text-muted">{{ auth()->user()->email }}</small>
                                </div>
                            </div>
                            {!! $reply->description !!}

                            <p style="text-align:right;">Posted On {{ $reply->created_at->format('d-m-Y'); }}</p>
                            <hr/>
                        </div>
                    @endforeach
                @endif
                <div class="card-body">
                    <a href="javascript: void(0);" class="btn btn-secondary waves-effect mt-4" data-bs-toggle="modal" data-bs-target="#composemodal"><i class="mdi mdi-reply me-1"></i> Reply</a>
                </div>
            </div>
        </div>
        <!-- card -->

    </div>
    <!-- end Col -->

</div>
<!-- end row -->
<!-- Modal -->
<div class="modal fade" id="composemodal" tabindex="-1" role="dialog" aria-labelledby="composemodalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.drivers.tickets.reply.store')  }}">
                @csrf
                <input type="hidden" name="ticket_replyable_id" value="{{ encrypt($ticket->id) }}" />
                <div class="modal-body">
                    <div>
                        <div class="mb-3 email-editor">
                            <textarea name="description" id="email-editor"></textarea>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Reply <i class="fab fa-telegram-plane ms-1"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end modal -->
@endsection
@section('script')
<script src="{{ URL::asset('assets/libs/@ckeditor/@ckeditor.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/pages/email-editor.init.js') }}"></script>
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
