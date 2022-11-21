<?php

namespace App\Http\Controllers\Api;

use App\Models\Tournament;
use App\Http\Controllers\AbstractController;
use App\Http\Requests\Tournament\StoreTournamentRequest;
use App\Http\Requests\Tournament\UpdateTournamentRequest;
use App\Http\Resources\TournamentResource;
use App\Repositories\Interfaces\GameRepositoryInterface;
use App\Repositories\Interfaces\PlayerRepositoryInterface;
use App\Repositories\Interfaces\TournamentRepositoryInterface;
use App\Services\TournamentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TournamentController extends AbstractController
{
    /**
     * @var TournamentService $service
     */
    protected TournamentService $service;

    /**
     * __construct
     *
     * @param  TournamentRepositoryInterface $repository
     * @return void
     */
    public function __construct(
        TournamentRepositoryInterface $repository,
        GameRepositoryInterface $gameRepository,
        PlayerRepositoryInterface $playerRepository,
    ) {
        $this->service = new TournamentService($repository, $gameRepository, $playerRepository);
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $tournaments = $this->service->allPaginatedAndFiltered($request->all());
        return TournamentResource::collection($tournaments)
            ->response()
            ->setStatusCode(200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreTournamentRequest  $request
     * @return JsonResponse
     */
    public function store(StoreTournamentRequest $request): JsonResponse
    {
        $tournament = $this->service->store($request->validated());
        return TournamentResource::make($tournament)
            ->response()
            ->setStatusCode(201);
    }
    
    /**
     * start
     *
     * @param  mixed $request
     * @return JsonResponse
     */
    public function start(Request $request): JsonResponse
    {
        $tournament = $this->service->start($request->all());
        return TournamentResource::make($tournament)
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  Tournament  $tournament
     * @return JsonResponse
     */
    public function show(Tournament $tournament): JsonResponse
    {
        return TournamentResource::make($tournament)
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateTournamentRequest  $request
     * @param  Tournament  $tournament
     * @return JsonResponse
     */
    public function update(UpdateTournamentRequest $request, Tournament $tournament): JsonResponse
    {
        $tournament = $this->service->update($tournament, $request->validated());
        return TournamentResource::make($tournament)
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Tournament  $tournament
     * @return JsonResponse
     */
    public function destroy(Tournament $tournament): JsonResponse
    {
        if ($this->service->destroy($tournament)) {
            $message = 'the requested resource has been deleted';
            $status = true;
            $code = 202;
            return $this->simpleJsonResponse($message, $status, $code);
        }
        $message = 'the requested resource cannot be deleted';
        $status = false;
        $code = 409;
        return $this->simpleJsonResponse($message, $status, $code);
    }
}
