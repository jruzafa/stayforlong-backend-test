<?php

declare(strict_types=1);

namespace App\StayforlongBundle\Controller;

use InvalidArgumentException;
use Psr\Log\LoggerInterface;
use Stayforlong\Booking\Application\CalculateStats;
use Stayforlong\Booking\Infrastructure\BookingRequestValidator;
use Stayforlong\Booking\Infrastructure\StatsPresenter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class GetBookingStatsController
{
	private BookingRequestValidator $statsRequestValidator;
	private CalculateStats $calculateStatsUseCase;
	private LoggerInterface $logger;

	public function __construct(
		CalculateStats $calculateStatsUseCase,
		BookingRequestValidator $statsRequestValidator,
		LoggerInterface $logger,
	) {
		$this->calculateStatsUseCase = $calculateStatsUseCase;
		$this->statsRequestValidator = $statsRequestValidator;
		$this->logger = $logger;
	}

	public function __invoke(Request $request): Response
	{
		try {
			$bookingRequests = $request->getContent();
			$bookingRequests = json_decode($bookingRequests, true, JSON_THROW_ON_ERROR);

			$this->statsRequestValidator->validate($bookingRequests);

			$statsResponse = $this->calculateStatsUseCase->__invoke($bookingRequests);

			$statsPresenter = new StatsPresenter(
				$statsResponse->avgNight(),
				$statsResponse->minNight(),
				$statsResponse->maxNight(),
			);

			return new JsonResponse($statsPresenter->toArray());
		} catch (InvalidArgumentException $exception) {
			return new JsonResponse([$exception->getMessage()], Response::HTTP_BAD_REQUEST);
		} catch (Throwable $exception) {
			$this->logger->error($exception->getMessage());

			return new JsonResponse(['Internal Server Error'], Response::HTTP_INTERNAL_SERVER_ERROR);
		}
	}
}
