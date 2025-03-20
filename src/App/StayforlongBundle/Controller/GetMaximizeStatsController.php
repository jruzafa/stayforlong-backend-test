<?php

declare(strict_types=1);

namespace App\StayforlongBundle\Controller;

use Psr\Log\LoggerInterface;
use Stayforlong\Booking\Application\CalculateMaximizeBooking;
use Stayforlong\Booking\Application\CalculateMaximizeBookingRequest;
use Stayforlong\Booking\Infrastructure\BookingRequestValidator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class GetMaximizeStatsController
{
    private BookingRequestValidator $statsRequestValidator;
    private CalculateMaximizeBooking $maximizeCalculatorUseCase;
    private LoggerInterface $logger;

    public function __construct(
        CalculateMaximizeBooking $maximizeCalculator,
        BookingRequestValidator $statsRequestValidator,
        LoggerInterface $logger,
    )
    {
        $this->maximizeCalculatorUseCase = $maximizeCalculator;
        $this->statsRequestValidator = $statsRequestValidator;
        $this->logger = $logger;
    }

    public function __invoke(Request $request): Response
    {
        try {
            $collectionBookingRequest = $request->getContent();
            $collectionBookingRequest = json_decode($collectionBookingRequest, true);

            $this->statsRequestValidator->validate($collectionBookingRequest);

            $statsResponse = $this->maximizeCalculatorUseCase->__invoke(
                new CalculateMaximizeBookingRequest($collectionBookingRequest),
            );

            // todo: move to presenter?
            return new JsonResponse($statsResponse);
        } catch (\InvalidArgumentException $exception) {
            return new JsonResponse([$exception->getMessage()], Response::HTTP_BAD_REQUEST);
        } catch (\Throwable $exception) {
            $this->logger->error($exception->getMessage());

            return new JsonResponse(['Internal Server Error'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}