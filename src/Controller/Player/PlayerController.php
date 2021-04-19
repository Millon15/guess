<?php

namespace Guess\Controller\Player;

use Exception;
use Guess\Application\CreatePlayerHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PlayerController extends AbstractController
{
    public function __construct(
        private CreatePlayerHandler $playerHandler,
    ) {
    }

    public function index(Request $request): Response
    {
        try {
            $playerArray = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
            $playerArray['avatar'] ??= 2;
            $this->playerHandler->handle($playerArray);
        } catch(Exception $e) {
            return $this->json([
                'message' => $e->getMessage(),
            ], 400);
        }

        return $this->json([
            'message' => 'User created!',
        ], 201);
    }
}
