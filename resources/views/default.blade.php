<?php
// the route function isnt very good when it comes to passing extra params in, it will just take any param as a route param even if the name doesnt match
$routeWithGet = function ($route, $routeParams = [], $get = []) {
    $url = route($route, $routeParams);
    $get = http_build_query($get);
    if (mb_strpos($url, '?') === false) {
        $url .= '?' . $get;
    } else {
        $url .= '&' . $get;
    }
    return $url;
}
?>
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
                @foreach ($marker->options() as $route => $options)
                    @if(empty($options['condition']) || $options['condition']())
                        <li {!! !empty($options['nested'])?'class="dropdown-submenu"':'' !!}>
                            <a href="{{route($route, isset($options['routeParam'])?$options['routeParam']:[])}}">
                                {{trans($options['name'])}}
                            </a>
                            @if(!empty($options['nested']))
                                <ul class="dropdown-menu">
                                    @foreach($marker->nestedOptions($options['nested']) as $nroute => $option)
                                        <li>
                                            <a href="{{$routeWithGet($route, isset($options['routeParam'])?$options['routeParam']:[],
                                                   ['type' => $options['nested'], 'action' => $nroute])}}">
                                                {{trans($option['name'])}}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endif
                @endforeach
                <li><a href="#" data-marker="clear"
                       data-marker-type="{{$marker->type()}}">{{trans('marker::marker.clear-selection')}}</a></li>
            </ul>
        </div>
    @endif
</div>
