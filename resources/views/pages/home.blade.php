@extends('layouts.app')

@section('title', '首页')

@section('content')
    <div class="container">
        @isset($courses)
            @foreach ($courses as $course)
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <a class="cover mt-4 mt-sm-0" href="{{ route('course.show', $course) }}"><img class="img-fluid img-shadow" src="{{ $course->cover }}"></a>
                                    </div>
                                    <div class="col-sm-9">
                                        <div class="name mt-4 mt-sm-0">{{ $course->name }}</div>
                                        <div class="intro">
                                            <p>{{ $course->intro }}</p>
                                        </div>
                                        <div class="extra">
                                            <a href="{{ route('course.show', $course) }}" class="btn btn-primary btn-w-150">了解更多</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endisset
    </div>
@endsection
