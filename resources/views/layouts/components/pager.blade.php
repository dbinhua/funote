<div style="text-align: center;margin:38px 0;position: absolute;bottom: 0;left: 0;right: 0;">
    <div class="ui pagination menu">
        @foreach($pageOptions as $option)
            <a class="page-click item @if($option['active']) active @endif @if($option['disabled']) disabled @endif" data-page="{{ $option['pageIndex'] }}">
                {{ $option['pageText'] }}
            </a>
        @endforeach
    </div>
</div>
