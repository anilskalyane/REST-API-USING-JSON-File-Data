<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class UsersController extends Controller {

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        try {
            $sampleData = \Helper::loadJSONData();
            $this->user = $sampleData['Users'];
            $this->roles = $sampleData['Roles'];
            $this->permissionsData = $sampleData['Permissions'];
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 401);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        return response()->json([
                    'status' => 'success',
                    'message' => 'Data Processed successfully',
                    'data' => $this->user
                        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CandidateReferee  $candidateReferee
     * @return \Illuminate\Http\Response
     */
    public function show($user_id) {
        $data = [];
        try {
            if ($this->user['id'] !== trim($user_id)) {
                return response()->json(['status' => 'error', 'message' => 'User not exist!'], 401);
            }
            $data['user'] = $this->user;
            $res_data = \Helper::getUserPermission($this->user, $data);
            return response()->json(['status' => 'success', 'message' => 'Data Processed successfully', 'data' => $res_data], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 401);
        }
    }

}
