<?php


namespace App\Http\Controllers\Document\Report;


use App\Http\Controllers\Controller;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use MealWallet\Domain\Document\Service\DocumentServiceInterface;

class GetAllReportDocumentController extends Controller
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
     * @param string $reportId
     * @return JsonResponse
     */
    public function fetchByReport(string $reportId)
    {
        $documents = $this
            ->documentService
            ->fetchWithReportId(
                $reportId
            );

        /*$documents = $this
            ->documentService
            ->populateCollectionWithDocumentTypeData(
                $documents
            );*/

        return response()->json([
            'status' => 'success',
            'data' => [
                'Documents' => $documents->toArray()
            ]
        ]);
    }
}
