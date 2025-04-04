<?php

namespace App\Tests\Acceptance\Stayforlong\Booking;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GetMaximizeBookingControllerTest extends WebTestCase
{
    private const string API_ENDPOINT = '/api/v1/booking/maximize';

    public function testGivenBookingRequestWhenCalculateMaximizeThenStatsReturned(): void
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
                        "request_id" => "acme_AAAAA",
                        "check_in" => "2026-01-10",
                        "nights" => 4,
                        "selling_rate" => 160,
                        "margin" => 30
                    ],
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
                    ],
                    [
                        "request_id" => "atropote_AA930",
                        "check_in" => "2026-01-04",
                        "nights" => 4,
                        "selling_rate" => 150,
                        "margin" => 6
                    ],

                ]
            )
        );

        self::assertResponseIsSuccessful();
        self::assertJsonStringEqualsJsonFile(
            __DIR__ . '/maximize_expected_response.json',
            $browserClient->getResponse()->getContent()
        );
    }

    public function testGivenEmptyBookingRequestWhenCalculateMaximizeThenBadRequestStatusReturned(): void
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
