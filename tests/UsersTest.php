<?php

//use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UsersTest extends TestCase {

    /**
     * Testing the all Positive cases 
     */
    public function testShouldReturnAllUsers() {
        $this->get("user", [], 'Testing the Users all Positive cases');
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            "status",
            "message",
            "data"
        ]);
    }

    public function testShouldReturnUsersPermissions() {
        $this->get("user/user1", []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            "status",
            "message",
            "data"
        ]);
    }

    /**
     * Negative cases
     */
    public function it_should_throw_an_error_when_the_required_columns_are_not_filled() {
        $this->get("user/user4", []);
        $this->seeStatusCode(401);
        $this->seeJsonStructure([
            "status",
            "message",
            "data"
        ]);
    }

}
