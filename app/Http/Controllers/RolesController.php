<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Validator;

class RolesController extends Controller {

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        try {
            $sampleData = \Helper::loadJSONData();
            $this->permissionsData = $sampleData['Permissions'];
            $this->roles = $sampleData['Roles'];
            $this->fullData = $sampleData;
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
                    'data' => $this->roles
                        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request) {
        try {
            $requestData = $request->only('permissions');
            $validator = \Validator::make($requestData, ['permissions' => 'required|array|min:1']);

            if ($validator->fails()) {
                return response()->json($validator->messages());
            }
            $searchInArray = array_search($id, array_column($this->roles, 'id'));
            if (!is_numeric($searchInArray)) {
                return response()->json(['status' => 'error', 'message' => 'Role not exist!'], 401);
            }
            //set the json object element as requested data
            $this->fullData['Roles'][$searchInArray]['permissions'] = $requestData['permissions'];
            //Update date to json file
            \Helper::writeJSONData($this->fullData);
            return response()->json(['status' => 'success', 'message' => 'Roles data Updated successfully', 'data' => $this->fullData['Roles']], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 401);
        }
    }

}
