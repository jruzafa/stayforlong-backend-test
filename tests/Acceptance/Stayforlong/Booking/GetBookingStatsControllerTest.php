<?php

namespace App\Tests\Acceptance\Stayforlong\Booking;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GetBookingStatsControllerTest extends WebTestCase
{
    private const string API_ENDPOINT = '/api/v1/booking/stats';

    public function testGivenBookingRequestWhenCalculateThenStatsReturned(): void
    {
        $browserClient = static::createClient();

        $browserClient->request(
            'POST',
            self::API_ENDPOINT,
            [],
            [],
            [],
            json_encode(
                [
                    [
                        "request_id" => "bookata_XY123",
                        "check_in" => "2026-01-01",
                        "nights" => 5,
                        "selling_rate" => 200,
                        "margin" => 20
                    ],
                    [
                        "request_id" => "kayete_PP234",
                        "check_in" => "2026-01-04",
                        "nights" => 4,
                        "selling_rate" => 156,
                        "margin" => 22
                    ]
                ]
            )
        );

        self::assertResponseIsSuccessful();
        self::assertJsonStringEqualsJsonFile(
            __DIR__ . '/stats_expected_response.json',
            $browserClient->getResponse()->getContent()
        );
    }

    public function testGivenEmptyBookingRequestWhenCalculateStatsThenBadRequestStatusReturned(): void
    {
        $browserClient = static::createClient();

        $browserClient->request(
            'POST',
            self::API_ENDPOINT,
            [],
            [],
            [],
            json_encode([])
        );

        self::assertResponseStatusCodeSame(400);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        restore_exception_handler();
    }
}
