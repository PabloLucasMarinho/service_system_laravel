<ol class="breadcrumb d-flex justify-content-start">
  @foreach ($items as $item)
    @if(isset($item['url']))
      <li class="breadcrumb-item">
        <a href="{{ $item['url'] }}" class="">{{ $item['label'] }}</a>
      </li>
    @else
      <li class="breadcrumb-item active">{{ $item['label'] }}</li>
    @endif
  @endforeach
</ol>
