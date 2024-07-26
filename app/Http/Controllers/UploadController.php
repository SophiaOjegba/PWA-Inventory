<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Upload;

class UploadController extends Controller
{
    public function uploadFile(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('uploads');

            $upload = new Upload();
            $upload->equipment_id = $request->equipment_id;
            $upload->file_path = $path;
            $upload->updated_at = now();
            $upload->save();

            return response()->json(['status' => 'success', 'file_path' => $path, 'updated_at' => $upload->updated_at]);
        }

        return response()->json(['status' => 'failed']);
    }

    public function syncUploads(Request $request)
    {
        $validatedData = $request->validate([
            'uploads.*.equipment_id' => 'required|string',
            'uploads.*.file_path' => 'required|string',
            'uploads.*.updated_at' => 'required|date',
        ]);

        try {
            foreach ($validatedData['uploads'] as $upload) {
                $existingUpload = Upload::where('equipment_id', $upload['equipment_id'])
                                        ->orderBy('updated_at', 'desc')
                                        ->first();

                if ($existingUpload) {
                    // Check which upload is newer
                    if ($upload['updated_at'] > $existingUpload->updated_at) {
                        // Update with the new upload
                        $existingUpload->file_path = $upload['file_path'];
                        $existingUpload->updated_at = $upload['updated_at'];
                        $existingUpload->save();
                    }
                } else {
                    // Save new upload
                    Upload::create([
                        'equipment_id' => $upload['equipment_id'],
                        'file_path' => $upload['file_path'],
                        'updated_at' => $upload['updated_at']
                    ]);
                }
            }

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            \Log::error('Sync uploads failed: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Failed to synchronize uploads'], 500);
        }
    }
}

