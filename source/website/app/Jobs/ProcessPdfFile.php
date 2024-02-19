<?php

namespace App\Jobs;

use App\Models\Document;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;
use Spatie\Image\Manipulations;

class ProcessPdfFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $document;
    protected $startPage;
    protected $numPages;

    /**
     * Create a new job instance.
     */
    public function __construct(Document $document, int $startPage = 1, int $numPages = 10)
    {
        $this->document = $document;
        $this->startPage = $startPage;
        $this->numPages = $numPages;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $pathToPdf = storage_path('app/private/'.$this->document->attachment);
        $destinationPath = 'documents/' . $this->document->id;
        $directory = public_path('storage/' . $destinationPath);
        File::makeDirectory($directory, 0755, true, true);

        $pdf = new \Spatie\PdfToImage\Pdf($pathToPdf);
        $pdf->setOutputFormat('jpg');
        $pdf->setCompressionQuality(100);

        $prefix = 'page-';

        $numberOfPages = $pdf->getNumberOfPages();

        if ($numberOfPages !== 0) {
            $limit = min($this->numPages + $this->startPage - 1, $numberOfPages);
            array_map(function ($pageNumber) use ($pdf, $destinationPath, $directory, $prefix) {
                $pdf->setPage($pageNumber);

                $destinationFilePath = "{$destinationPath}/{$prefix}{$pageNumber}.jpg";
                $destination = "{$directory}/{$prefix}{$pageNumber}.jpg";

                $pdf->saveImage($destination);

                \Spatie\Image\Image::load($destination)
                    ->watermark(public_path('/img/logo_white.png'))
                    ->watermarkOpacity(50)
                    ->watermarkWidth(40, Manipulations::UNIT_PERCENT)
                    ->watermarkPosition(Manipulations::POSITION_CENTER)
                    ->save();

                $this->document->increment('attachment_num_image');
                $attachmentPages = $this->document->attachment_pages;
                $attachmentPages[$pageNumber] = $destinationFilePath;
                $this->document->attachment_pages = $attachmentPages;
                $this->document->save();
            }, range($this->startPage, $limit));
        }
    }
}
