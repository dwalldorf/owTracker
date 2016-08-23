<?php

namespace Tests\FeedbackBundle\Controller;

use AppBundle\DTO\BaseCollection;
use AppBundle\Util\AppSerializer;
use FeedbackBundle\Document\Feedback;
use FeedbackBundle\DTO\FeedbackDto;
use FeedbackBundle\Service\FeedbackService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tests\BaseWebTestCase;
use UserBundle\Document\User;

class FeedbackControllerTest extends BaseWebTestCase {

    /**
     * @test
     */
    public function getAll() {
        $this->mockSessionUser();
        $settings = $this->mockedSessionUser->getUserSettings();
        $settings->setIsAdmin(true);
        $this->mockedSessionUser->setUserSettings($settings);

        $mockedFeedbackUser = new User('fakeId', 'username');

        $mockedFeedback1 = new Feedback();
        $mockedFeedback1->setCreatedBy($mockedFeedbackUser->getId());
        $mockedFeedback2 = new Feedback();
        $mockedFeedback2->setCreatedBy($mockedFeedbackUser->getId());

        $mockFeedbackService = $this->getMockBuilder(FeedbackService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mockFeedbackService->expects($this->once())
            ->method('getAll')
            ->willReturn([$mockedFeedback1, $mockedFeedback2]);
        $mockFeedbackService->expects($this->once())
            ->method('toDto')
            ->willReturn([new FeedbackDto($mockedFeedbackUser, $mockedFeedback1), new FeedbackDto($mockedFeedbackUser, $mockedFeedback2)]);

        $this->mockService($mockFeedbackService, FeedbackService::ID);

        /* @var BaseCollection $responseItemCollection */
        $response = $this->apiRequest(Request::METHOD_GET, '/feedback');
        $responseItemCollection = $this->getEntityFromRequest($response, BaseCollection::class);

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertEquals(2, $responseItemCollection->getTotalItems());
    }

    /**
     * @test
     */
    public function getAllRequiresLogin() {
        $response = $this->apiRequest(Request::METHOD_GET, '/feedback');
        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function getAllRequiresAdmin() {
        $this->mockSessionUser();
        $settings = $this->mockedSessionUser->getUserSettings();
        $settings->setIsAdmin(false);
        $this->mockedSessionUser->setUserSettings($settings);

        $response = $this->apiRequest(Request::METHOD_GET, '/feedback');
        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function getByIdRequiresLogin() {
        $response = $this->apiRequest(Request::METHOD_GET, '/feedback/someFakeId');
        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function getByIdRequiresAdmin() {
        $this->mockSessionUser();
        $settings = $this->mockedSessionUser->getUserSettings();
        $settings->setIsAdmin(false);
        $this->mockedSessionUser->setUserSettings($settings);

        $response = $this->apiRequest(Request::METHOD_GET, '/feedback/someFakeId');
        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function submitRequiresLogin() {
        $feedback = new Feedback();
        $feedback->setFeedback(['fixplease' => 'this and that']);

        $response = $this->apiRequest(Request::METHOD_POST, '/feedback', $feedback);
        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function submitSetsTimestampAndUser() {
        $feedback = new Feedback();
        $feedback->setFeedback(['fixplease' => 'this and that']);
        $this->mockSessionUser();

        /* @var Feedback $responseFeedback */
        $response = $this->apiRequest(Request::METHOD_POST, '/feedback', $feedback);
        $responseFeedback = $this->getEntityFromRequest($response, Feedback::class);

        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        $this->assertEquals($this->mockedSessionUser->getId(), $responseFeedback->getCreatedBy());
        // created timestamp within last 5 seconds
        $this->assertTrue($responseFeedback->getCreated()->getTimestamp() > (time() - 5));
    }
}