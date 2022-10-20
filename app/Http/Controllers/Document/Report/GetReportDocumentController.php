<?php


namespace App\Http\Controllers\Document\Report;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use MealWallet\Domain\Document\Service\DocumentServiceInterface;

class GetReportDocumentController extends Controller
{

    /**
     * @var DocumentServiceInterface
     */
    private $documentService;

    /**
     * GetUserDocumentController constructor.
     * @param DocumentServiceInterface $documentService
     */
    public function __construct(DocumentServiceInterface $documentService)
    {
        $this->documentService = $documentService;
    }

    /**
     * @param string $documentId
     * @return JsonResponse
     * @throws FileNotFoundException
     */
    public function fetch(
        string $documentId
    )
    {

        $document = $this
            ->documentService
            ->fromDocumentId(
                $documentId
            );

        $url = $file = Storage::disk('s3')->url($document->getPath());
        $file = Storage::disk('s3')->get($document->getPath());

        return response()->json([
            'status' => 'success',
            'data' => [
                'Document' => [
                    'reportId' => $document->getReportId(),
                    'documentId' => $document->getDocumentId(),
                    'timestamp' => $document->getTimestamp(),
                   // 'content' => base64_encode($file),
                    'fileName' => $document->getFileName(),
                    'fileExtension' => $document->getFileExtension(),
                    'fileMimeType' => $document->getFileMimeType(),
                    'url' => $url
                ]
            ]
        ]);
    }
}
