<div class="marker-dropdown" data-marker-type="{{$marker->type()}}">
    @if($marker->count())
        <div class="dropdown">
            <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="true">
                {{trans('marker::marker.selected', ['count' => $marker->count()])}}
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
                @yield('options', '')
                <li><a href="#" data-marker="clear"
                       data-marker-type="{{$marker->type()}}">{{trans('marker::marker.clear-selection')}}</a></li>
            </ul>
        </div>
    @endif
</div>
