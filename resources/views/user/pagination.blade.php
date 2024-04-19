@if ($paginator->hasPages())
    <div class="pagination">
        @if ($paginator->onFirstPage())
            <a href="" ><i class="fas fa-chevron-left buttonoff"></i></a>
        @else
            <a href="{{$paginator->previousPageUrl()}}"><i class="fas fa-chevron-left buttonon"></i></a>              
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <a href="" class="numberoff">{{$element}}</a>
            @endif

            @if (is_array($element))
                @foreach ($element as $page=>$url)
                    @if ($page == $paginator->currentPage())
                        <a href="" class="numberon">{{$page}}</a>
                    @else
                        <a href="{{$url}}" class="numberoff">{{$page}}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
        <a href="{{$paginator->nextPageUrl()}}"><i class="fas fa-chevron-right buttonon"></i></a>
    @else
        <a href=""><i class="fas fa-chevron-right buttonoff"></i></a>              
    @endif
    </div>
@endif