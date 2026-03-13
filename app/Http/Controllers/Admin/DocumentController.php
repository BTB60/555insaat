<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Worker;
use App\Models\Site;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index(): View
    {
        $documents = Document::with(['documentable', 'uploadedBy'])
            ->latest()
            ->paginate(20);
        
        return view('admin.documents.index', compact('documents'));
    }

    public function create(): View
    {
        $workers = Worker::with('user')->active()->get();
        $sites = Site::active()->get();
        
        return view('admin.documents.create', compact('workers', 'sites'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'required|file|max:10240', // 10MB max
            'category' => 'required|in:id_card,contract,certificate,medical,site_doc,other',
            'documentable_type' => 'required|in:worker,site',
            'documentable_id' => 'required|integer',
            'expiry_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $file = $request->file('file');
        $path = $file->store('documents', 'public');

        $documentableType = $validated['documentable_type'] === 'worker' 
            ? Worker::class 
            : Site::class;

        Document::create([
            'documentable_type' => $documentableType,
            'documentable_id' => $validated['documentable_id'],
            'title' => $validated['title'],
            'file_path' => $path,
            'file_type' => $file->getClientMimeType(),
            'file_size' => $file->getSize(),
            'category' => $validated['category'],
            'expiry_date' => $validated['expiry_date'] ?? null,
            'uploaded_by' => auth()->id(),
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->route('admin.documents.index')
            ->with('success', 'Sənəd uğurla yükləndi.');
    }

    public function show(Document $document): View
    {
        $document->load(['documentable', 'uploadedBy']);
        
        return view('admin.documents.show', compact('document'));
    }

    public function download(Document $document)
    {
        if (!Storage::disk('public')->exists($document->file_path)) {
            return redirect()->back()->with('error', 'Fayl tapılmadı.');
        }

        return Storage::disk('public')->download($document->file_path, $document->title);
    }

    public function destroy(Document $document): RedirectResponse
    {
        // Delete file from storage
        if (Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }

        $document->delete();

        return redirect()->route('admin.documents.index')
            ->with('success', 'Sənəd silindi.');
    }

    public function byWorker(Worker $worker): View
    {
        $documents = $worker->documents()->with('uploadedBy')->latest()->paginate(20);
        
        return view('admin.documents.by_worker', compact('worker', 'documents'));
    }

    public function bySite(Site $site): View
    {
        $documents = $site->documents()->with('uploadedBy')->latest()->paginate(20);
        
        return view('admin.documents.by_site', compact('site', 'documents'));
    }
}
