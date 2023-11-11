<?php

namespace App\MediaLibrary\Conversions\ImageGenerators;

use Illuminate\Support\Collection;
use Spatie\MediaLibrary\Conversions\Conversion;
use Spatie\MediaLibrary\Conversions\ImageGenerators\ImageGenerator;

class Pdf extends ImageGenerator
{
    public function convert(string $file, Conversion $conversion = null): string
    {
        $imageFile = pathinfo($file, PATHINFO_DIRNAME).'/'.pathinfo($file, PATHINFO_FILENAME).'.jpg';

        $pageNumber = $conversion ? $conversion->getPdfPageNumber() : 1;

        $pdf = new \Spatie\PdfToImage\Pdf($file);
        $pdf->setPage($pageNumber)
            ->setCompressionQuality(100)
            ->saveImage($imageFile);

        return $imageFile;
    }

    public function requirementsAreInstalled(): bool
    {
        if (! class_exists(\Imagick::class)) {
            return false;
        }

        if (! class_exists(\Spatie\PdfToImage\Pdf::class)) {
            return false;
        }

        return true;
    }

    public function supportedExtensions(): Collection
    {
        return collect(['pdf']);
    }

    public function supportedMimeTypes(): Collection
    {
        return collect(['application/pdf']);
    }
}
