@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="transaction-section padding-top padding-bottom">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card primary-bg text-white">
                        <div class="card-body">
                            <div class="treeview-container">
                                <ul class="treeview">
                                    <li class="items-expanded"> {{ $user->fullname }} ( {{ $user->username }} )
                                        @include($activeTemplate.'partials.under_tree',['user'=>$user,'layer'=>0,'isFirst'=>true])
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <link href="{{ asset('assets/global/css/jquery.treeView.css') }}" rel="stylesheet" type="text/css">
@endpush
@push('script')
<script src="{{ asset('assets/global/js/jquery.treeView.js') }}"></script>
<script>
    (function($){
    "use strict"
        $('.treeview').treeView();
    })(jQuery);
</script>
@endpush
