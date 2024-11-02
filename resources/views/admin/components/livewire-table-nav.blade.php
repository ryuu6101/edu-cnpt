<div>
    @if(isset($collection) && $collection !== null && count($collection) > 0)
        <div class="py-2" style="font-size: 15px;">
            <strong>Hiển thị {{ $collection->firstItem() }} - {{ $collection->lastItem() }} / Tổng {{ $collection->total() }}</strong>
        </div>
    
        <nav class="d-flex justify-content-center">
            @if (isset($collection) && count($collection) > 0)
                {!! $collection->links('admin.helpers.livewire-paginate', ['page_name' => $page_name ?? 'page']) !!}
            @endif
        </nav>
    @endif
</div>