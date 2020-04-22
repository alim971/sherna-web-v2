<div class="col-md-4">
    <div class="x_panel">
        <div class="x_title">
            <h2>Consoles types</h2>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('type.create') }}"><i class="fa fa-plus"></i></a>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">

            <table class="table">
                <thead>
                <tr>
                    <th>Name</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($consoleTypes as $consoleType)
                    <tr>
                        <td>{{$consoleType->name}}</td>
                        <td>
                            <form action="{{ route('type.destroy', ['type' => $consoleType]) }}" class="inline" method="post">
                                @csrf
                                @method('DELETE')
                                <a class="btn btn-warning" href="{{ route('type.edit', ['type' => $consoleType])}}"><i
                                        class="fa fa-pencil"></i></a>
                                <button class="btn btn-danger" type="submit"><i class="fa fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
