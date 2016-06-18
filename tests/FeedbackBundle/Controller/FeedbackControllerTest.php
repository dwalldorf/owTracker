<?php

namespace Tests\FeedbackBundle\Controller;

use AppBundle\Util\AppSerializer;
use FeedbackBundle\Document\Feedback;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tests\BaseWebTestCase;

class FeedbackControllerTest extends BaseWebTestCase {

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
        $this->mockedSessionUser->setIsAdmin(false);

        $response2 = $this->apiRequest(Request::METHOD_GET, '/feedback');
        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response2->getStatusCode());
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
        $this->mockedSessionUser->setIsAdmin(false);

        $response = $this->apiRequest(Request::METHOD_GET, '/feedback/someFakeId');
        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function submitRequiresLogin() {
        $feedback = new Feedback();
        $feedback->setFeedback(['fixplease' => 'this and that']);
        $jsonFeedback = AppSerializer::getInstance()->toJson($feedback);

        $response = $this->apiRequest(Request::METHOD_POST, '/feedback', $jsonFeedback);
        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function submitSetsTimestampAndUser() {
        $feedback = new Feedback();
        $feedback->setFeedback(['fixplease' => 'this and that']);
        $jsonFeedback = AppSerializer::getInstance()->toJson($feedback);
        $this->mockSessionUser();

        /* @var Feedback $responseFeedback */
        $response = $this->apiRequest(Request::METHOD_POST, '/feedback', $jsonFeedback);
        $responseFeedback = AppSerializer::getInstance()->fromJson($response->getContent(), Feedback::class);

        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        $this->assertEquals($this->mockedSessionUser->getId(), $responseFeedback->getCreatedBy());
        $this->assertTrue($responseFeedback->getCreatedTimestamp() > (time() - 5)); // created timestamp within last 5 seconds
    }
}