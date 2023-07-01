@extends('layouts.dashboard')

@section('content')
@include('layouts.partial.dashborad-aside')
<div class="content-wrapper">
    @include($group->dashboard)
</div>
@endsection