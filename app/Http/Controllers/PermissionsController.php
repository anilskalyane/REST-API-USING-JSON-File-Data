<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class PermissionsController extends Controller {

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        try {
            $sampleData = \Helper::loadJSONData();
            $this->permissionsData = $sampleData['Permissions'];
            $this->user = $sampleData['Users'];
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
                    'data' => $this->permissionsData
                        ], 200);
    }

    /**
     * Check the user's permission
     *
     * @return \Illuminate\Http\Response
     */
    public function checkpermission($permission_id, $user_id) {

        try {
            $data = [];
            if ($this->user['id'] !== trim($user_id)) {
                return response()->json(['status' => 'error', 'message' => 'User not exist!'], 401);
            }
            $res_data = \Helper::getUserPermission($this->user, $data);
            foreach ($res_data['user_permissions'] as $userPermissions) {
                $searchInArray = array_search($permission_id, array_column($userPermissions, 'id'));
                if (is_numeric($searchInArray)) {
                    return response()->json(['status' => 'success', 'message' => 'User has Permission', 'data' => true], 200);
                }
            }
            return response()->json(['status' => 'error', 'message' => 'User did not have the permission'], 401);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CandidateReferee  $candidateReferee
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        try {
            if (!\Helper::deleteJSONDatafromFile('Permissions', 'id', $id)) {
                return response()->json(['status' => 'error', 'message' => 'Permission element not exist!', 'data' => []], 401);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage(), 'data' => []], 401);
        }

        return response()->json(null, 204);
    }

}
