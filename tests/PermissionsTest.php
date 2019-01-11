<?php

//use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PermissionsTest extends TestCase {

    /**
     * Testing the all Positive cases 
     */
    public function testShouldReturnAllPermissions() {
        $this->get("permissions", []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            "status",
            "message",
            "data" => [
                [
                    "id", "name"
                ]
            ]
        ]);
    }

    public function testShouldCheckUserPermissions() {
        $this->get("checkpermission/user1/perm1");
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            "status",
            "message",
            "data"
        ]);
    }

//    public function testShouldDeleteThePermissions() {
//        $this->delete("permissions/permD");
//        $this->seeStatusCode(204);
//        $this->seeJsonStructure([]);
//    }

    /**
     * Negative cases
     */
    public function it_should_throw_an_error_when_the_required_columns_are_not_filled() {
        $this->put("checkpermission/role1/users1", []);
        $this->seeStatusCode(401);
        $this->seeJsonStructure([
            "status",
            "message",
            "data"
        ]);
    }

    public function it_should_throw_an_error_when_the_delete_required_columns_are_not_filled() {
        $this->delete("permissions/permTest");
        $this->seeStatusCode(401);
        $this->seeJsonStructure([]);
    }

}
