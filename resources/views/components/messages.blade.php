@if(isset($_GET['success']))
    @if($_GET['success'])
        <div class="row">
            <div class="col-12">
                <div class="alert alert-{{ $_GET['success'] ? 'success' : 'danger' }} alert-dismissible fade show">
                    {!! $_GET['message'] !!}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
    @else
        {{-- Errors Handlings --}}
        @if($_GET['shop_id'])
            @php $errors = \App\Services\SellerService::getErrors($_GET['shop_id']) @endphp
            <div class="row">
                <div class="col-12">
                    @if(count($errors)>0)
                        <div class="alert alert-danger alert-dismissible fade show">
                            <ul class="mb-0">
                                @foreach($errors as $error)
                                    <li>{{ $error->message }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close"
                                    style="background-color: transparent;border: none !important;"
                                    data-bs-dismiss="alert" aria-label="Close">
                                <i class="fa fa-times-circle"></i>
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    @endif
@endif
