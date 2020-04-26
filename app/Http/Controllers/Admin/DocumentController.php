<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use File;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function index()
    {
        $docs = File::allFiles(public_path('docs'));

        return view('admin.doc.index', ['docs' => $docs]);
    }

    public function upload(Request $request)
    {
        $this->validate($request, ['file' => 'required']);

        if ($request->file('file')->isValid()) {
            $request->file->move(public_path('docs/'), $request->file->getClientOriginalName());
            flash()->success('Súbor úspešne nahraný.');
        } else {
            flash()->error('Súbor je poškodený.');
        }

        return redirect()->route('document.index');
    }

    public function delete($path)
    {
        File::delete(public_path('docs/' . $path));

        flash()->success('Súbor úspešne zmazaný.');

        return redirect()->route('document.index');
    }
}
