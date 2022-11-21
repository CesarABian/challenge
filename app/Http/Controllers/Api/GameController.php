<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AbstractController;
use App\Http\Requests\Api\Game\StoreGameRequest;
use App\Http\Requests\Api\Game\UpdateGameRequest;
use App\Http\Resources\GameResource;
use App\Models\Game;
use App\Repositories\Interfaces\GameRepositoryInterface;
use App\Services\GameService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GameController extends AbstractController
{
    /**
     * @var GameService $service
     */
    protected GameService $service;

    /**
     * __construct
     *
     * @param  GameRepositoryInterface $repository
     * @return void
     */
    public function __construct(GameRepositoryInterface $repository)
    {
        $this->service = new GameService($repository);
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $games = $this->service->allPaginatedAndFiltered($request->all());
        return GameResource::collection($games)
            ->response()
            ->setStatusCode(200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreGameRequest  $request
     * @return JsonResponse
     */
    public function store(StoreGameRequest $request): JsonResponse
    {
        $game = $this->service->store($request->validated());
        return GameResource::make($game)
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  Game  $game
     * @return JsonResponse
     */
    public function show(Game $game): JsonResponse
    {
        return GameResource::make($game)
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateGameRequest  $request
     * @param  Game  $game
     * @return JsonResponse
     */
    public function update(UpdateGameRequest $request, Game $game): JsonResponse
    {
        $game = $this->service->update($game, $request->validated());
        return GameResource::make($game)
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Game  $game
     * @return JsonResponse
     */
    public function destroy(Game $game): JsonResponse
    {
        if ($this->service->destroy($game)) {
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
