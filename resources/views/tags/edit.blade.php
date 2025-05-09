@extends('layouts.app')

@section('title', __("Edit Tag"))

@section('heading')
    {{ __('Tags') }}
@stop

@section('content')

    @component('layouts.partials.card')
        @slot('cardHeader', __('Edit Tag'))

        @slot('cardBody')
            <form action="{{ route('sendportal.tags.update', $tag->id) }}" method="POST" class="form-horizontal">
                @csrf
                @method('PUT')

                @include('tags.partials.form')

                <x-sendportal.submit-button :label="__('Save')" />
            </form>
        @endSlot
    @endcomponent

@stop
