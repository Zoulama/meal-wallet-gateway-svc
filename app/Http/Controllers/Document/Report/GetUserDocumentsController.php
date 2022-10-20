<?php


namespace App\Http\Controllers\Document\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use MealWallet\Domain\Document\Service\DocumentServiceInterface;
use Illuminate\Http\JsonResponse;

class GetUserDocumentsController extends Controller
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
     * @param Request $request
     * @return JsonResponse
     */
    public function fetchAll(
        string $userId,
        Request $request
    ){

        $filter = [];

        if($request->query('type')){
            $filter['type'] = $request->query('type');
        }
        if($request->query('status')){
            $filter['status'] = $request->query('status');
        }

        if($request->query('latest')){
            $filter['latest'] = $request->query('latest') == 'true' ? true : false;
        }

        $documents = $this
            ->documentService
            ->fromUserId(
                $userId,
                $filter
            );
        $documents = $this
            ->documentService
            ->populateCollectionWithDocumentTypeData(
                $documents
            );

        return response()->json([
            'status' => 'success',
            'data' => [
                'Documents' => $documents->toArray()
            ]
        ]);
    }
}
