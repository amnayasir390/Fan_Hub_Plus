<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

trait HandlesImageUploads
{
    protected function storeUploadedImage(Request $request, string $field, string $directory, ?string $oldPath = null): ?string
    {
        if (! $request->hasFile($field)) {
            return null;
        }

        if ($oldPath) {
            Storage::disk('public')->delete($oldPath);
        }

        return $request->file($field)->store($directory, 'public');
    }
}
