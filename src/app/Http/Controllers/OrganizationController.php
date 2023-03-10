<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Interfaces\OrganizationRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use App\Http\Resources\OrganizationResource;

class OrganizationController extends Controller
{
    private OrganizationRepositoryInterface $organizationRepository;

    public function __construct(OrganizationRepositoryInterface $organizationRepository) 
    {
        $this->organizationRepository = $organizationRepository;
    }

    public function index(Request $request): JsonResponse 
    {
        // Retrieving status filter.
        $status = $request->all()['status'] ?? 'all';

        try {
            $data = match ($status) {
                'subbed' => $this->organizationRepository->getSubbedOrganizations(),
                'trial' => $this->organizationRepository->getTrialOrganizations(),
                'all' => $this->organizationRepository->getAllOrganizations(),
            };

            return response()->json([
                'success' => TRUE,
                'message' => 'Organizations list',
                'data' => OrganizationResource::collection($data),
            ]);
        }
        catch (\Exception|\UnhandledMatchError $e) {
            return response()->json([
                'success' => FALSE,
                'message' => 'Organizations failed to retrieve',
            ]);
        }
    }

    public function store(Request $request): JsonResponse 
    {
        // Validation.
        $validated = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required|max:255',
        ]);
        if (!$validated) {
            return response()->json([
                'success' => FALSE,
                'message' => 'Validation failed',
            ]);
        }

        // Forming data.
        $data = $request->only([
            'name',
            'description',
        ]);
        $data['trial_end'] = date('Y-m-d H:i:s', strtotime('+30 days'));
        $data['user_id'] = auth()->user()->id;
        $data['subscribed'] = 0;

        try {
            $resp = response()->json(
                [
                    'success' => TRUE,
                    'message' => 'Organization created',
                    'data' => OrganizationResource::make($this->organizationRepository->createOrganization($data)),
                ],
                Response::HTTP_CREATED
            );
        }
        catch (\Exception $e) {
            return response()->json([
                'success' => FALSE,
                'message' => 'Organization failed to creat',
            ]);
        }

        // Seninding email.
        Http::withHeaders([
            'Api-Token' => env('MAILTRAP_API_KEY'),
            'Content-Type' => 'application/json',
        ])->post(env('MAILTRAP_API_URL') . '/api/send', [
            'to' => [
                [
                    'email' => auth()->user()->email,
                    'name' => auth()->user()->name,
                ],
            ],
            'from' => [
                'email' => env('SITE_EMAIL'),
                'name' => env('SITE_NAME'),
            ],
            'subject' => 'Organization created',
            'text' => 'Organization created',
        ]);

        return $resp;
    }
}
