<?php

declare(strict_types=1);

namespace App\StayforlongBundle\Controller;

use InvalidArgumentException;
use Psr\Log\LoggerInterface;
use Stayforlong\Booking\Application\CalculateMaximizeBooking;
use Stayforlong\Booking\Infrastructure\BookingRequestValidator;
use Stayforlong\Booking\Infrastructure\MaximizeStatsPresenter;
use Stayforlong\Booking\Infrastructure\StatsPresenter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class GetMaximizeBookingController
{
	private BookingRequestValidator $statsRequestValidator;
	private CalculateMaximizeBooking $maximizeCalculatorUseCase;
	private LoggerInterface $logger;

	public function __construct(
		CalculateMaximizeBooking $maximizeCalculator,
		BookingRequestValidator $statsRequestValidator,
		LoggerInterface $logger,
	) {
		$this->maximizeCalculatorUseCase = $maximizeCalculator;
		$this->statsRequestValidator = $statsRequestValidator;
		$this->logger = $logger;
	}

	public function __invoke(Request $request): Response
	{
		try {
			$bookingRequests = $request->getContent();
			$bookingRequests = json_decode($bookingRequests, true);

			$this->statsRequestValidator->validate($bookingRequests);

			$statsResponse = $this->maximizeCalculatorUseCase->__invoke($bookingRequests);

			$presenter = new StatsPresenter(
				$statsResponse->avgNight(),
				$statsResponse->minNight(),
				$statsResponse->maxNight()
			);

			$maximizePresenter = new MaximizeStatsPresenter($statsResponse->requestsIds(), $statsResponse->totalProfit());

			return new JsonResponse($presenter->toArray() + $maximizePresenter->toArray());
		} catch (InvalidArgumentException $exception) {
			return new JsonResponse([$exception->getMessage()], Response::HTTP_BAD_REQUEST);
		} catch (Throwable $exception) {
			$this->logger->error($exception->getMessage());

			return new JsonResponse(['Internal Server Error'], Response::HTTP_INTERNAL_SERVER_ERROR);
		}
	}
}
