<?php

namespace App\Listeners;

use App\Models\Document;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Mostafaznv\PdfOptimizer\Events\PdfOptimizerJobFinished;

class PdfOptimizerJobNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PdfOptimizerJobFinished $event): void
    {
        $document = Document::where('queue_id', $event->id)->first();
        if (!$document) {
            Log::error("Document not found for queue_id: $event->id");
            return;
        }
        $fileName = File::name(storage_path('app/private/' . $document->attachment));

        $originalFile = $document->attachment;
        $compressedFile = str_replace('documents/original/', 'documents/', $originalFile);

        Storage::delete('private/' . $originalFile);
        $compressedFileSize = Storage::size('private/' . $compressedFile);
        $compressedFilePath = 'documents/' . $document->id . '/' . $fileName . '.pdf';
        Storage::move('private/' . $compressedFile, 'private/' . $compressedFilePath);

        $document->update([
            'attachment' => $compressedFilePath,
            'attachment_compress_size' => $compressedFileSize,
        ]);

        $step = min(100, $document->attachment_num_pages);
        array_map(function ($pageNumber) use ($document, $step) {
            if ($pageNumber <= $document->attachment_num_pages) {
                dispatch(new \App\Jobs\ProcessPdfFile($document, $pageNumber, $step));
            }
        }, range(1, $document->attachment_num_pages + 1, $step));
    }
}
