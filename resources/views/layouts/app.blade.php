@extends('adminlte::page')

{{-- Extend and customize the browser title --}}

@section('title')
  {{ config('adminlte.title') }}
  @hasSection('subtitle')
    | @yield('subtitle')
  @endif
@stop

{{-- Extend and customize the page content header --}}

{{--@section('content_header')--}}
{{--  @hasSection('content_header_title')--}}
{{--    <h1 class="text-muted">--}}
{{--      @yield('content_header_title')--}}

{{--      @hasSection('content_header_subtitle')--}}
{{--        <small class="text-dark">--}}
{{--          <i class="fas fa-xs fa-angle-right text-muted"></i>--}}
{{--          @yield('content_header_subtitle')--}}
{{--        </small>--}}
{{--      @endif--}}
{{--    </h1>--}}
{{--  @endif--}}
{{--@stop--}}

{{-- Rename section content to content_body --}}

@section('content')
  @yield('content_body')
@stop

{{-- Create a common footer --}}

@section('footer')
  <div class="d-flex justify-content-end">
    <strong>
      Feito por:
      <a href="{{ config('app.dev_url', '#') }}" target="_blank" class="text-dark">
        {{ config('app.dev_name', 'Pablo Marinho') }}
      </a>
    </strong>
  </div>
@stop
