<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AbstractController;
use App\Http\Requests\Api\Player\StorePlayerRequest;
use App\Http\Requests\Api\Player\UpdatePlayerRequest;
use App\Http\Resources\PlayerResource;
use App\Models\Player;
use App\Repositories\Interfaces\PlayerRepositoryInterface;
use App\Services\PlayerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PlayerController extends AbstractController
{
    /**
     * @var PlayerService $service
     */
    protected PlayerService $service;

    /**
     * __construct
     *
     * @param  PlayerRepositoryInterface $repository
     * @return void
     */
    public function __construct(PlayerRepositoryInterface $repository)
    {
        $this->service = new PlayerService($repository);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $players = $this->service->allPaginatedAndFiltered($request->all());
        return PlayerResource::collection($players)
            ->response()
            ->setStatusCode(200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StorePlayerRequest $request
     * @return JsonResponse
     */
    public function store(StorePlayerRequest $request): JsonResponse
    {
        $player = $this->service->store($request->validated());
        return PlayerResource::make($player)
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  Player  $player
     * @return JsonResponse
     */
    public function show(Player $player): JsonResponse
    {
        return PlayerResource::make($player)
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdatePlayerRequest  $request
     * @param  Player  $player
     * @return JsonResponse
     */
    public function update(UpdatePlayerRequest $request, Player $player):JsonResponse
    {
        $player = $this->service->update($player, $request->validated());
        return PlayerResource::make($player)
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Player  $player
     * @return JsonResponse
     */
    public function destroy(Player $player): JsonResponse
    {
        if ($this->service->destroy($player)) {
            $message = 'the requested resource cannot be deleted';
            $status = false;
            $code = 409;
            return $this->simpleJsonResponse($message, $status, $code);
        }
        $message = 'the requested resource has been deleted';
        $status = true;
        $code = 204;
        return $this->simpleJsonResponse($message, $status, $code);
    }
}
