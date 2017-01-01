    <div class="{{$class}}">
        {!! $html !!}
    </div>
@if ($isRow > 11 || $key == $max)
    <div class="clearfix"></div>
@endif
