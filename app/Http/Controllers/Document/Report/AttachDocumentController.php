<?php


namespace App\Http\Controllers\Document\Report;

use App\Http\Controllers\Controller;
use Aws\S3\Exception\S3Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use MealWallet\Domain\Document\Entity\DocumentEntity;
use MealWallet\Domain\Document\Service\DocumentServiceInterface;
use MealWallet\Domain\Report\Service\Exception\ReportServiceException;
use MealWallet\Domain\Report\Service\ReportServiceInterface;
use Ramsey\Uuid\Uuid;

class AttachDocumentController extends Controller
{

    /**
     * @var DocumentServiceInterface
     */
    private $documentService;

    /**
     * @var ReportServiceInterface
     */
    private $reportService;

    /**
     * AttachDocumentController constructor.
     * @param DocumentServiceInterface $documentService
     * @param ReportServiceInterface $reportService
     */
    public function __construct(
        DocumentServiceInterface $documentService,
        ReportServiceInterface  $reportService
    ){
        $this->documentService = $documentService;
        $this->reportService = $reportService;
    }

    /**
     * @param string $reportId
     * @param Request $request
     * @return JsonResponse
     */
    public function attach(
        string $reportId,
        Request $request
    )
    {
        try {

            $file = $request->file('content');
            $filePath = sprintf(
                'reports/%s/%s',
                $reportId,
                Uuid::uuid4()
            );

            Storage::disk('s3')
                ->put(
                    $filePath,
                    file_get_contents($file),
                    [
                        ["content-length-range", 1048576, 10485760]
                    ]
                );

            Storage::disk('s3')->setVisibility($filePath, 'public');

            $url = Storage::disk('s3')->url($filePath);

            $document = new DocumentEntity(
                null,
                $reportId,
                $filePath,
                $url,
                $file->getClientOriginalName(),
                $file->getClientOriginalExtension(),
                $file->getClientMimeType(),
                time()
            );

            try {
                $reportEntity =  $this
                    ->reportService
                    ->fetch($reportId);

            } catch (ReportServiceNotFoundException $e) {
                return response()->json(
                    [
                        'status' => 'error',
                        'StatusCode' => 404,
                        'message' => 'Report not found'
                    ], 404
                );
            }

            $document = $this
                ->documentService
                ->store($document);

            try {
                $reportEntity->setImagesUrlData(
                    $this
                        ->documentService
                        ->fetchWithReportId(
                            $reportId
                        )->toArray()
                );

                $this->reportService->update(
                    $reportEntity->getReportId(),
                    $reportEntity
                );
            } catch (ReportServiceNotFoundException $e) {
                return response()->json(
                    [
                        'status' => 'error',
                        'StatusCode' => 404,
                        'message' => $e->getMessage()
                    ], 404
                );
            }

            return response()->json([
                'status' => 'success',
                'data' => [
                    'Document' => $document->toArray()
                ]
            ]);

        } catch (S3Exception $s3Exception) {
            return response()->json([
                'status' => 'Error',
                'message' => $s3Exception->getMessage()
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'status' => 'Error',
                'message' => $ex->getMessage()
            ]);
        }
    }
}
