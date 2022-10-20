<?php


namespace App\Http\Controllers\Document\Report;


use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use MealWallet\Domain\Document\Service\DocumentServiceInterface;

class UpdateUserDocumentController extends Controller
{
    /**
     * @var DocumentServiceInterface
     */
    private $documentService;

    /**
     * GetUserDocumentsController constructor.
     * @param DocumentServiceInterface $documentService
     */
    public function __construct(
        DocumentServiceInterface $documentService
    ){
        $this->documentService = $documentService;
    }


    /**
     * @param string $userId
     * @param string $documentId
     * @param Request $request
     * @return JsonResponse
     */
    public function updateStatus(
        string $userId,
        string $documentId,
        Request $request

    ){
        $document = $this
            ->documentService
            ->updateStatus(
                $documentId,
                $request->json('status'),
                $request->json('comment')
            );

        return response()->json([
            'status' => 'success',
            'data' => [
                'Document' => $document->toArray()
            ]
        ]);
    }
}
