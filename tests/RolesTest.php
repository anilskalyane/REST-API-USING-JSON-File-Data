<?php

//use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RolesTest extends TestCase {

    /**
     * Testing the all Positive cases 
     */
    public function testShouldReturnAllRoles() {
        $this->get("roles", []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            "status",
            "message",
            "data"
        ]);
    }

    public function testShouldUpdatesTheRoles() {
        $parameters = ["permissions" => ["perm1", "perm5"]];
        $this->put("roles/role1", $parameters, []);
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
        $this->put("roles/role1", []);
        $this->seeStatusCode(401);
        $this->seeJsonStructure([
            "status",
            "message",
            "data"
        ]);
    }

}
