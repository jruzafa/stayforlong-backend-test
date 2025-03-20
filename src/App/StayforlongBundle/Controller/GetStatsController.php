<?php

declare(strict_types=1);

namespace App\StayforlongBundle\Controller;

use Psr\Log\LoggerInterface;
use Stayforlong\Booking\Application\CalculateStats;
use Stayforlong\Booking\Application\CalculateStatsRequest;
use Stayforlong\Booking\Infrastructure\BookingRequestValidator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class GetStatsController
{
    private BookingRequestValidator $statsRequestValidator;
    private CalculateStats $calculateStatsUseCase;
    private LoggerInterface $logger;

    public function __construct(
        CalculateStats $calculateStatsUseCase,
        BookingRequestValidator $statsRequestValidator,
        LoggerInterface $logger,
    )
    {
        $this->calculateStatsUseCase = $calculateStatsUseCase;
        $this->statsRequestValidator = $statsRequestValidator;
        $this->logger = $logger;
    }

    public function __invoke(Request $request): Response
    {
        try {
            $collectionBookingRequest = $request->getContent();
            $collectionBookingRequest = json_decode($collectionBookingRequest, true, JSON_THROW_ON_ERROR);

            $this->statsRequestValidator->validate($collectionBookingRequest);

            $statsResponse = $this->calculateStatsUseCase->__invoke(
                new CalculateStatsRequest($collectionBookingRequest),
            );

            // todo: move to presenter?
            return new JsonResponse([
                'avg_night' => $statsResponse->avgNight(),
                'min_night' => $statsResponse->minNight(),
                'max_night' => $statsResponse->maxNight()
            ]);
        } catch (\InvalidArgumentException $exception) {
            return new JsonResponse([$exception->getMessage()], Response::HTTP_BAD_REQUEST);
        } catch (\Throwable $exception) {
            $this->logger->error($exception->getMessage());

            return new JsonResponse(['Internal Server Error'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}