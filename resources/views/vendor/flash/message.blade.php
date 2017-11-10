{{--@foreach (session('flash_notification', collect())->toArray() as $message)--}}
    {{--@if ($message['overlay'])--}}
        {{--@include('flash::modal', [--}}
            {{--'modalClass' => 'flash-modal',--}}
            {{--'title'      => $message['title'],--}}
            {{--'body'       => $message['message']--}}
        {{--])--}}
    {{--@else--}}
        {{--<div class="alert--}}
                    {{--alert-{{ $message['level'] }}--}}
                    {{--{{ $message['important'] ? 'alert-important' : '' }}"--}}
                    {{--role="alert"--}}
        {{-->--}}
            {{--@if ($message['important'])--}}
                {{--<button type="button"--}}
                        {{--class="close"--}}
                        {{--data-dismiss="alert"--}}
                        {{--aria-hidden="true"--}}
                {{-->&times;</button>--}}
            {{--@endif--}}

            {{--{!! $message['message'] !!}--}}
        {{--</div>--}}
    {{--@endif--}}
{{--@endforeach--}}

{{--{{ session()->forget('flash_notification') }}--}}
{{--@if(Session::has('flash_message'))--}}
    {{--<p class="alert alert-info">{{ Session::get('flash_message') }}</p>--}}
{{--@endif--}}

@if ( session()->has("errorMessage") )
    <div class="callout callout-danger">
        <h4>Warning!</h4>
        <p>{!! session("errorMessage") !!}</p>
    </div>
    {{ session()->forget('errorMessage') }}
@elseif ( session()->has("successMessage") )
    <div class="callout callout-success">
        <h4>Success</h4>
        <p>{!! session("successMessage") !!}</p>
    </div>
    {{ session()->forget('successMessage') }}
@else
    <div></div>
@endif
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif