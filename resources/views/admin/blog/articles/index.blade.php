@extends('layouts.admin')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Articles</h2>
                    <div class="pull-right">
                        <a class="btn btn-primary" href="{{ route('article.create') }}"><i class="fa fa-plus"></i></a>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <table class="table">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Url</th>
                            <th>Public</th>
                            <th>Categories</th>
                            <th>Created at</th>
                            <th>Updated at</th>
                            <th>Created by</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($articles as $article)
                            <tr>
                                <td>{{ $article->text->title }}</td>
                                <td>{{ $article->url }}</td>
                                <td><span class="label label-{{$article->public ? 'success':'warning'}}">{{$article->public ? 'Public':'In prepare'}}</span></td>
                                <td>
                                    @forelse($article->categories as $category)
                                        <span class="label label-info ">{{ $category->detail->name }}</span>
                                    @empty
                                        <span class="label label-warning "> No categories </span>
                                    @endforelse

                                </td>
                                <td>{{ $article->created_at->isoFormat('LLL') }}</td>
                                <td>{{ $article->updated_at->isoFormat('LLL') }}</td>
{{--                                <td>{{ $article->user->name }}</td>--}}
                                <td></td>
                                <td>
                                    <form action="{{ route('article.destroy',['article' => $article]) }}" class="inline" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <a class="btn btn-warning" href="{{ route('article.edit' ,$article) }}"><i
                                                class="fa fa-pencil"></i></a>
                                        <a href="{{ route('article.public', ['article' => $article]) }}" class="btn btn-{{$article->public ? "danger" : "primary"}} primary"><i
                                                class="fa {{$article->public ? "fa-eye-slash" : "fa-eye"}} "></i></a>
                                        <button class="btn btn-danger" type="submit"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center" colspan="8"> No articles yet </td>
                            </tr>
                        @endforelse
                        @if($articles->hasPages())
                            <tr>
                                <td class="text-center" colspan="8">{{ $articles->links() }}</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
