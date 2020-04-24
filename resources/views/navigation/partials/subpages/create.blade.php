<h1>Tvorba podstranky</h1>

    <form action="{{ route('subnavigation.store') }}" method="POST">
        @csrf
        <div>
            <div class="form-group">
                <label for="sub_url">Url</label>
                <input type="text" name="sub_url" id="sub_url" class="form-control" value="{{old('sub_url') }}" required minlength="3" maxlength="10"/>
            </div>
            <div class="form-group">
                <label for="sub_order">Order</label>
                <input type="text" name="sub_order" id="sub_order" class="form-control" value="{{old('sub_order') }}"/>
            </div>
            <div class="form-group">
                <label for="sub_public">Is public</label>
                <input type="checkbox" name="sub_public" id="sub_public" class="form-control" {{(!empty(old('sub_public'))) ? "checked" : "" }} />
            </div>

            <ul class="nav nav-tabs" style="margin-bottom: 3%">
                @foreach(\App\Language::all() as $language)
                    <li class="{{($language->id==1 ? "active":"")}}">
                        <a href="#sub_{{$language->id}}" data-toggle="tab">{{$language->name}}</a>
                    </li>
                @endforeach
            </ul>
            <div class="tab-content">
                @foreach(\App\Language::all() as $language)
                    <div class="tab-pane fade {{($language->id==1 ? "active":"")}} in" id="sub_{{$language->id}}">
                        <div class="form-group">
                            <div class="form-group">
                                <label for="sub_name-{{$language->id}}">Name</label>
                                <input type="text" name="sub_name-{{$language->id}}" id="sub_name-{{$language->id}}" class="form-control" value="{{old('sub_name-' . $language->id)}}" required minlength="3" maxlength="10"/>
                            </div>

                            <div class="form-group">
                                <label for="sub_text_content">Obsah článku</label>
                                <textarea name="sub_text_content-{{$language->id}}" id="sub_text_content-{{$language->id}}" class="form-control edit" rows="8">
                                {{ old('sub_text_content-' . $language->id) }}
                            </textarea>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <button type="submit" class="btn btn-primary">Uložit podstranku</button>
        </div>
    </form>

@include('client.blog.partials.summernote')

