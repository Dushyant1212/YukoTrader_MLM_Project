<ul @if($isFirst) class="firstList" @endif>
    @foreach($user->allReferrals as $under)
        @if($loop->first)
            @php $layer++ @endphp
        @endif
        <li>{{ $under->fullname }} ( {{ $under->username }} )
            @if(($under->allReferrals->count()) > 0 && ($layer < $general->matrix_height))
                @include($activeTemplate.'partials.under_tree',['user'=>$under,'layer'=>$layer,'isFirst'=>false])
            @endif
        </li>
    @endforeach
</ul>
