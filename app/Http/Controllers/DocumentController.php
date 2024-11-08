<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpWord\TemplateProcessor;
class DocumentController extends Controller
{
    public function openDocument($id)
    {
        // Load the Word document associated with this ID
        $filePath = storage_path("app/documents/document_$id.docx");
        return response()->file($filePath, [
            'Content-Disposition' => 'inline; filename="document.docx"'
        ]);
    }

    public function signDocument(Request $request, $id)
    {
        $filePath = storage_path("app/documents/document_$id.docx");
        $templateProcessor = new TemplateProcessor($filePath);

        $templateProcessor->setValue('signature', 'Your Signature Text or Image Here');

        $newFilePath = storage_path("app/documents/document_{$id}_signed.docx");
        $templateProcessor->saveAs($newFilePath);

        return response()->download($newFilePath);
    }
}
